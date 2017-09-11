<?php


namespace app\helpers;


use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class ValMap
{

    /**
     * @param int|float $from
     * @param int|float $to
     * @param null $suffix
     * @param null $prefix
     * @param int $steps
     * @return array
     */
    public static function range($from, $to, $suffix = null, $prefix = null, $steps = 1) {
        $values = [];
        for ($val = $from; $val <= $to; $val = $val + $steps) {
            $values[$val] = $prefix . $val . $suffix;
        }
        return $values;
    }

    /**
     * @param ActiveRecord|string $modelClass
     * @param string $indexAttr
     * @param string $labelAttr
     * @return array
     */
    public static function model($modelClass, $indexAttr, $labelAttr) {
        return ArrayHelper::map(
            $modelClass::find()->all(),
            $indexAttr,
            $labelAttr
        );
    }

}