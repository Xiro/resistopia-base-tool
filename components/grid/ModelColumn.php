<?php

namespace app\components\grid;

use app\customs\exception\RuntimeException;
use yii\db\ActiveRecord;
use yii\grid\DataColumn;

class ModelColumn extends DataColumn
{

    public $separator = ", ";

    /**
     * Returns the data cell value.
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @return string the data cell value
     */
    public function getDataCellValue($model, $key, $index)
    {
        $value = parent::getDataCellValue($model, $key, $index);

        if($value instanceof ActiveRecord) {
            return $this->getModelName($value);
        } elseif (is_array($value) || $value instanceof \ArrayAccess || $value instanceof \Traversable) {
            $relatedValues = [];
            foreach ($value as $relatedModel) {
                $relatedValues[] = $this->getModelName($relatedModel);
            }
            return implode($this->separator, $relatedValues);
        } else {
            return $this->getModelName($value);
        }
    }

    /**
     * @param $model
     * @return string
     */
    protected function getModelName($model)
    {
        if(is_object($model) && method_exists($model, "__toString")) {
            return $model->__toString();
        }

        if($model instanceof ActiveRecord) {
            foreach ($model::getTableSchema()->getColumnNames() as $name) {
                if (!strcasecmp($name, 'name') || !strcasecmp($name, 'title') || !strcasecmp($name, 'value')) {
                    return $model->$name;
                }
            }

            $rules = $model->rules();
            foreach ($rules as $rule) {
                if($rule[1] == "unique") {
                    $showAttributes = $rule[0];
                }
            }
            if(!isset($showAttributes)) {
                throw new RuntimeException("Invalid model in ModelColumn: " . get_class($model) . " must have unique values or __toString() method");
            }

            $attributeValues = [];
            foreach ($showAttributes as $showAttribute) {
                $attributeValues[] = $model->$showAttribute;
            }
            return implode(" - ", $attributeValues);
        }

        throw new RuntimeException("Invalid ModelColumn value provided, expected instance of ActiveRecord, got " . (is_object($model) ? get_class($model) : gettype($model)));
    }

}