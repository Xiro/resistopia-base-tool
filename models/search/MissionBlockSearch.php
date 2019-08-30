<?php

namespace app\models\search;

use app\models\MissionBlock;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MissionBlockSearch represents the model behind the search form about `app\models\MissionBlock`.
 */
class MissionBlockSearch extends MissionBlock
{
    use AdvancedSearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['blocked_staff_member_sid', 'blocked_by_sid', 'unblock_time', 'reason', 'created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MissionBlock::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $this->searchDates($query, [
            'unblock_time' => $this->unblock_time,
            'created'      => $this->created,
        ]);

        $this->searchCaseInsensitive($query, [
            'blocked_staff_member_sid' => $this->blocked_staff_member_sid,
            'blocked_by_sid'           => $this->blocked_by_sid,
        ]);

        $this->searchFulltext($query, $this->reason, 'reason');

        return $dataProvider;
    }
}
