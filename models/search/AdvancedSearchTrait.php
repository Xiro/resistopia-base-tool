<?php


namespace app\models\search;


use yii\db\ActiveQuery;

trait AdvancedSearchTrait
{

    /**
     * @param ActiveQuery $query
     * @param $search
     * @param array $fields
     * @param string $separator
     * @param boolean $caseSensitive
     */
    public function searchFulltext(ActiveQuery $query, $search, array $fields, $separator = ' ', $caseSensitive = false)
    {
        $nameParts = explode($separator, $search);
        $whereName = ['and'];
        foreach ($nameParts as $namePart) {
            $whereNamePart = ['or'];
            foreach ($fields as $field) {
                if($caseSensitive) {
                    $whereNamePart[] = ['like', $field, $namePart];
                } else {
                    $whereNamePart[] = ['like', 'lower(' . $field . ')', strtolower($namePart)];
                }
            }
            $whereName[] = $whereNamePart;
        }
        $query->andFilterWhere($whereName);
    }

    /**
     * @param ActiveQuery $query
     * @param $where
     */
    public function searchDates(ActiveQuery $query, array $where)
    {
        $order = [];
        foreach ($where as $column => $dateTime) {
            if(empty($dateTime)) {
                continue;
            }
            $dateTime = date('Y-m-d H:i', strtotime($dateTime));
            $order["ABS(TIMEDIFF($column, '$dateTime'))"] = 'ASC';
        }
        $query->orderBy($order);
    }

    public function searchCaseInsensitive(ActiveQuery $query, array $where)
    {
        foreach ($where as $key => $value) {
            $operator = 'like';
            if(is_array($value) && isset($value[0])) {
                if(count($value) > 2) {
                    $operator = $value[0];
                    $column = $value[1];
                    $search = $value[2];
                } else {
                    $column = $value[0];
                    $search = $value[1];
                }
            } else {
                $column = $key;
                $search = $value;
            }
            $query->andFilterWhere([$operator, "lower($column)", strtolower($search)]);
        }
    }

}