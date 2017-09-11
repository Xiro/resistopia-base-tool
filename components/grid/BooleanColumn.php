<?php

namespace app\components\grid;

use yii\grid\DataColumn;

class BooleanColumn extends DataColumn
{

    /**
     * Value returned if the column data is true
     * @var string
     */
    public $valueTrue = '<span class="glyphicon glyphicon-ok boolean-true"></span>';

    /**
     * Value returned if the column data is false
     * @var string
     */
    public $valueFalse = '<span class="glyphicon glyphicon-remove boolean-false"></span>';

    /**
     * Value returned if the column data is NULL
     * @var string
     */
    public $valueNull = '<span class="glyphicon glyphicon-minus boolean-null"></span>';

    /**
     * Column data which will be considered true
     * @var array
     */
    public $trueValues = ["Y", "Yes", 1, "1", true];

    /**
     * Column data which will be considered false
     * @var array
     */
    public $falseValues = ["N", "No", 0, "0", false];

    /**
     * @inheritdoc
     */
    public $format = "html";

    /**
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     * @return string
     */
    public function getDataCellValue($model, $key, $index)
    {
        $value = parent::getDataCellValue($model, $key, $index);

        if(in_array($value, $this->trueValues, true)) {
            return $this->valueTrue;
        }

        if(in_array($value, $this->falseValues, true)) {
            return $this->valueFalse;
        }

        return $this->valueNull;
    }


}