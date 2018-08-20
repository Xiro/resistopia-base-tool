<?php


namespace app\models\search;


use yii\db\ActiveQuery;

trait FulltextSearchTrait
{

    /**
     * @param ActiveQuery $query
     * @param $search
     * @param $fields
     * @param string $separator
     */
    public function searchParts(ActiveQuery $query, $search, $fields, $separator = ' ')
    {
        $nameParts = explode($separator, $search);
        $whereName = ['and'];
        foreach ($nameParts as $namePart) {
            $whereNamePart = ['or'];
            foreach ($fields as $field) {
                $whereNamePart[] = ['like', $field, $namePart];
            }
            $whereName[] = $whereNamePart;
        }
        $query->andFilterWhere($whereName);
    }

}