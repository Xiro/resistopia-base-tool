<?php


namespace app\helpers;

use Yii;
use yii\db\ActiveQuery;

class DebugSql
{

    public static function sqlString(ActiveQuery $query) {
        $query = clone $query;
        echo '<pre>';
        echo str_replace(
            ["INNER JOIN", "LEFT JOIN", "RIGHT JOIN", "WHERE", "GROUP BY", "ORDER BY"],
            ["\nINNER JOIN", "\nLEFT JOIN", "\nRIGHT JOIN", "\nWHERE", "\nGROUP BY", "\nORDER BY"],
            $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql
        );
        echo '</pre>';
    }

    public static function showColumns(ActiveQuery $query, array $columns) {
        $query = clone $query;
        $values = $query->select($columns)->asArray()->all();
        echo '<pre>';
        echo print_r($values);
        echo '</pre>';
        return $values;
    }

    public static function showColumn(ActiveQuery $query, $column) {
        $query = clone $query;
        $result = $query->asArray()->all();
        $values = array_column($result, $column);
        echo '<pre>';
        echo print_r($values);
        echo '</pre>';
        return $values;
    }

}