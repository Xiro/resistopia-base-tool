<?php


namespace mate\yii\generators\crud;


use Yii;
use yii\db\ActiveRecord;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

class Generator extends \yii\gii\generators\crud\Generator
{

    /**
     * Destination namespace of generated code for advanced yii template
     * @var string
     */
    public $templateDestination;
    public $formModelClass = '';
    public $generateFormModel = true;
    public $enableSelect2Fields = true;

    protected $requiredTemplateProperties = array(
        "sortable" => ["id", "order"],
    );

    public $booleanEnums = [
        ['Y', 'N'],
        ['Yes', 'No'],
        [1, 0],
        ['1', '0'],
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['templateDestination'], 'safe'],
            [['modelClass'], 'validateHasProperties'],
            [['formModelClass'], 'filter', 'filter' => 'trim'],
            [['formModelClass'], 'compare', 'compareAttribute' => 'modelClass', 'operator' => '!==', 'message' => 'Form Model Class must not be equal to Model Class.'],
            [['formModelClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['formModelClass'], 'validateNewClass'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'formModelClass' => 'Form Model Class',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'formModelClass' => 'This is the name of the form model class to be generated. You should provide a fully
                qualified namespaced class name, e.g., <code>app\models\PostForm</code>.',
        ]);
    }

    public function generate()
    {
        Yii::$app->language = "en";
        if (empty($this->formModelClass)) {
            $this->generateFormModel = false;
        }

        $files = parent::generate();

        if ($this->generateFormModel) {
            $formModel = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->formModelClass, '\\') . '.php'));
            $files[] = new CodeFile($formModel, $this->render('form.php'));
        }

        return $files;
    }

    public function validateHasProperties()
    {
        $requiredProperties = $this->requiredProperties();
        $modelClass = $this->modelClass;
        /** @var ActiveRecord $model */
        $model = new $modelClass;

        foreach ($requiredProperties as $property) {
            if (!$model->hasProperty($property)) {
                $this->addError('modelClass', "Model '$modelClass' does not have the required property '$property'.");
            }
        }
    }

    protected function requiredProperties()
    {
        if (isset($this->requiredTemplateProperties[$this->template])) {
            return $this->requiredTemplateProperties[$this->template];
        } else {
            return array();
        }
    }

    public function getNameAttribute($modelClass = null)
    {
        /* @var $modelClass \yii\db\ActiveRecord */
        $modelClass = $modelClass === null ? $this->modelClass : $modelClass;

        if (method_exists($modelClass, "nameAttribute")) {
            return $modelClass::nameAttribute();
        }

        foreach ($modelClass::getTableSchema()->getColumnNames() as $name) {
            if (
                !strcasecmp($name, 'name')
                || !strcasecmp($name, 'title')
                || !strcasecmp($name, 'value')
                || !strcasecmp($name, 'username')
            ) {
                return $name;
            }
        }

        /* @var $model \yii\db\ActiveRecord */
        $model = new $modelClass;
        $rules = $model->rules();
        foreach ($rules as $rule) {
            if ($rule[1] == "unique") {
                return current($rule[0]);
            }
        }

        $pk = $modelClass::primaryKey();
        return $pk[0];
    }


    public function generateAttributeLabel($name)
    {
        $name = str_replace("_id", "", $name);
        return Inflector::camel2words($name, true);
    }

    /**
     * Generates code for active field
     * @param string $attribute
     * @param int $tabOffset
     * @return string
     */
    public function generateActiveField($attribute, $tabOffset = 1)
    {
        $foreignKeyColumns = $this->getForeignKeyColumns();
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false || !isset($tableSchema->columns[$attribute])) {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $attribute)) {
                return "\$form->field(\$model, '$attribute')->passwordInput()";
            } else {
                return "\$form->field(\$model, '$attribute')";
            }
        }
        for ($t = ""; strlen($t) < $tabOffset * 4; $t .= "    ") true;
        $column = $tableSchema->columns[$attribute];
        if (in_array($attribute, $foreignKeyColumns)) {
            $relatedSchema = $this->getRelationSchema($attribute);
            if ($relatedSchema == false) {
                return '"" // $form->field($model, ' . $attribute . ')->dropDownList(/* insert related values */)->label(/* insert label */)';
            }
            $label = Inflector::camel2words(Inflector::id2camel(str_replace(["id", "ID", "Id", "_id"], "", $attribute)));
            if ($this->enableSelect2Fields) {
                return "\$form->field(\$model, '$attribute', [\n$t"
                    . "    'labelOptions' => ['class' => (\$model->$attribute ? 'move' : '')]\n$t"
                    . "])->widget(Select2::class, [\n$t"
                    . "    'showToggleAll' => false,\n$t"
                    . "    'data'          => ValMap::model(\n$t"
                    . "             " . $relatedSchema["class"] . "::class,\n$t"
                    . "             '" . $relatedSchema["primaryKey"] . "', \n$t"
                    . "             '" . $this->getNameAttribute($relatedSchema["class"]) . "'\n$t"
                    . "         ),\n$t"
                    . "    'options'       => [\n$t"
                    . "        'placeholder' => '',\n$t"
                    . "    ],\n$t"
                    . "    'pluginOptions' => [\n$t"
                    . "        'allowClear' => true,\n$t"
                    . "    ],\n$t"
                    . "])->label('$label')";
            } else {
                return '$form->field($model, \'' . $attribute . '\')->dropDownList(\yii\helpers\ArrayHelper::map(' . "\n$t    "
                    . $relatedSchema["class"] . '::find()->all(), "'
                    . $relatedSchema["primaryKey"] . '", "'
                    . $this->getNameAttribute($relatedSchema["class"]) . '"' . "\n$t"
                    . '), ["prompt" => ""])->label("' . $label . '")';
            }
        }
        if ($column->phpType === 'boolean') {
            return "\$form->field(\$model, '$attribute')->checkbox()";
        } elseif ($column->type === 'text') {
            return "\$form->field(\$model, '$attribute')->textarea(['rows' => 6])";
        } else {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                $input = 'passwordInput';
            } else {
                $input = 'textInput';
            }
            if (is_array($column->enumValues) && count($column->enumValues) > 0) {
                $dropDownOptions = [];
                foreach ($column->enumValues as $enumValue) {
                    $dropDownOptions[$enumValue] = Inflector::humanize($enumValue);
                }
                $dropdownValuesPrint = preg_replace("/\n\s*/", ' ', VarDumper::export($dropDownOptions));
                if ($this->enableSelect2Fields) {
                    return "\$form->field(\$model, '$attribute', [\n$t"
                        . "    'labelOptions' => ['class' => (\$model->$attribute ? 'move' : '')]\n$t"
                        . "])->widget(Select2::class, [\n$t"
                        . "    'showToggleAll' => false,\n$t"
                        . "    'data'          => $dropdownValuesPrint,\n$t"
                        . "    'options'       => [\n$t"
                        . "        'placeholder' => '',\n$t"
                        . "    ],\n$t"
                        . "    'pluginOptions' => [\n$t"
                        . "        'allowClear' => true,\n$t"
                        . "    ],\n$t"
                        . "])";
                } else {
                    return "\$form->field(\$model, '$attribute')->dropDownList("
                        . $dropdownValuesPrint . ", ['prompt' => ''])";
                }
            } elseif ($column->phpType !== 'string' || $column->size === null) {
                return "\$form->field(\$model, '$attribute')->$input()";
            } else {
                return "\$form->field(\$model, '$attribute')->$input(['maxlength' => true])";
            }
        }
    }

    public function getForeignKeyColumns()
    {
        $foreignKeyColumns = array();
        foreach ($this->getTableSchema()->foreignKeys as $ref) {
            unset($ref[0]);
            $foreignKeyColumns = array_merge(
                $foreignKeyColumns,
                array_keys($ref)
            );
        }
        return $foreignKeyColumns;
    }

    public function getRelationSchema($foreignKey)
    {
        foreach ($this->getTableSchema()->foreignKeys as $ref) {
            if (!isset($ref[$foreignKey])) {
                continue;
            }
            $relatedTableName = $ref[0];
            $relatedKey = $ref[$foreignKey];

            $relatedNamespace = substr($this->modelClass, 0, strrpos($this->modelClass, '\\'));
            $relatedClassName = Inflector::id2camel($relatedTableName, '_');
            $relatedClass = $relatedNamespace . '\\' . $relatedClassName;

            if (class_exists($relatedClass) && is_subclass_of($relatedClass, ActiveRecord::class)) {
                /** @var ActiveRecord $relatedClass */
                $relatedRules = $relatedClass::rules();
            } else {
                //echo "Related class $relatedClass does not exist or is not a child of ActiveRecord";
                return false;
            }

            $uniqueValues = [];
            foreach ($relatedRules as $relatedRule) {
                if ($relatedRule[1] == "unique") {
                    $uniqueValues = $relatedRule[0];
                }
            }

            return array(
                "class"        => $relatedClass,
                "className"    => $relatedClassName,
                "primaryKey"   => $relatedKey,
                "uniqueValues" => $uniqueValues
            );
        }
        //echo "No related schema found";
        return false;
    }

    /**
     * Generate a relation name for the specified table and a base name.
     * @param string $key a base name that the relation name may be generated from
     * @return string the relation name
     */
    public function getRelationName($key)
    {
        if (!empty($key) && substr_compare($key, 'id', -2, 2, true) === 0 && strcasecmp($key, 'id')) {
            $key = rtrim(substr($key, 0, -2), '_');
        }
        $name = lcfirst(Inflector::id2camel($key, '_'));
        return $name;
    }

    public function excludeColumnInViewTable($column)
    {
        $columnName = $column->name;
//        echo $columnName;
        if (
            in_array($columnName, $this->getTableSchema()->primaryKey)
            || preg_match('/\b(\w*password\w*)\b/', $columnName)
            || preg_match('/\b(\w*pass\w*)\b/', $columnName)
            || preg_match('/\b(\w*passwd\w*)\b/', $columnName)
            || preg_match('/\b(\w*passcode\w*)\b/', $columnName)
            || preg_match('/\b(\w*key\w*)\b/', $columnName)
            || preg_match('/\b(\w*id\w*)\b/', $columnName)
            || in_array($column->dbType, ['text', 'mediumtext', 'longtext', 'json'])
        ) return true;
        return false;
    }

    /**
     * Generates a string depending on enableI18N property
     *
     * @param string $string the text be generated
     * @param array $placeholders the placeholders to use by `Yii::t()`
     * @return string
     */
    public function generateString($string = '', $placeholders = [])
    {
        $string = addslashes($string);
        if ($this->enableI18N) {
            // If there are placeholders, use them
            if (!empty($placeholders)) {
                $ph = ",  [";
                $last = end($placeholders);
                foreach ($placeholders as $key => $value) {
                    $ph .= "'$key' => $value";
                    $ph .= $value === $last ? "" : ", ";
                }
                $ph .= "]";
            } else {
                $ph = '';
            }
            $str = "Yii::t('" . $this->messageCategory . "', '" . $string . "'" . $ph . ")";
        } else {
            // No I18N, replace placeholders by real words, if any
            if (!empty($placeholders)) {
                $phKeys = array_map(function ($word) {
                    return '{' . $word . '}';
                }, array_keys($placeholders));
                $phValues = array_values($placeholders);
                $str = "'" . str_replace($phKeys, $phValues, $string) . "'";
            } else {
                // No placeholders, just the given string
                $str = "'" . $string . "'";
            }
        }
        return $str;
    }
}