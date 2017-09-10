<?php


namespace app\templates\gii\crud;


use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

class Generator extends \yii\gii\generators\crud\Generator
{

    /**
     * Destination namespace of generated code for advanced yii template
     * @var string
     */
    public $templateDestination = "backend";

    protected $requiredTemplateProperties = array(
        "sortable"          => ["id", "order"],
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
            [['modelClass'], 'validateHasProperties'],
        ]);
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
     * @return string
     */
    public function generateActiveField($attribute)
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
        $column = $tableSchema->columns[$attribute];
        if (in_array($attribute, $foreignKeyColumns)) {
            $relatedSchema = $this->getRelationSchema($attribute);
            if ($relatedSchema == false) {
                return '"" // $form->field($model, ' . $attribute . ')->dropDownList(/* insert related values */)->label(/* insert label */)';
            }
            $label = Inflector::camel2words(Inflector::id2camel(str_replace(["id", "ID", "Id", "_id"], "", $attribute)));
            return '$form->field($model, \'' . $attribute . '\')->dropDownList(\yii\helpers\ArrayHelper::map(' . "\n        "
                . $relatedSchema["class"] . '::find()->all(), "'
                . $relatedSchema["primaryKey"] . '", "'
                . $this->getNameAttribute($relatedSchema["class"]) . '"' . "\n    "
                . '), ["prompt" => ""])->label("' . $label . '")';
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
                return "\$form->field(\$model, '$attribute')->dropDownList("
                    . preg_replace("/\n\s*/", ' ', VarDumper::export($dropDownOptions)) . ", ['prompt' => ''])";
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
            foreach ($relatedRules as $relatedRule) {
                if ($relatedRule[1] == "unique") {
                    $uniqueValues = $relatedRule[0];
                }
            }
            if (!isset($uniqueValues)) {
                //echo "No unique values found";
                return false;
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

}