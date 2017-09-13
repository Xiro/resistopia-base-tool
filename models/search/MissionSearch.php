<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mission;

/**
 * MissionSearch represents the model behind the search form about `app\models\Mission`.
 */
class MissionSearch extends Mission
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'RP', 'FP', 'mission_type_id', 'mission_status_id'], 'integer'],
            [['name', 'description', 'zone', 'started', 'ended', 'debrief_comment'], 'safe'],
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
        $query = Mission::find();

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
            'RP' => $this->RP,
            'FP' => $this->FP,
            'started' => $this->started,
            'ended' => $this->ended,
            'mission_type_id' => $this->mission_type_id,
            'mission_status_id' => $this->mission_status_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'zone', $this->zone])
            ->andFilterWhere(['like', 'debrief_comment', $this->debrief_comment]);

        return $dataProvider;
    }
}
