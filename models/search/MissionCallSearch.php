<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MissionCall;

/**
 * MissionCallSearch represents the model behind the search form about `app\models\MissionCall`.
 */
class MissionCallSearch extends MissionCall
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'RP', 'FP', 'fighter', 'radio', 'medic', 'technician', 'science', 'guard', 'vip', 'mission_type_id'], 'integer'],
            [['name', 'description', 'zone', 'scheduled_start', 'scheduled_end'], 'safe'],
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
        $query = MissionCall::find();

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
            'scheduled_start' => $this->scheduled_start,
            'scheduled_end' => $this->scheduled_end,
            'fighter' => $this->fighter,
            'radio' => $this->radio,
            'medic' => $this->medic,
            'technician' => $this->technician,
            'science' => $this->science,
            'guard' => $this->guard,
            'vip' => $this->vip,
            'mission_type_id' => $this->mission_type_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'zone', $this->zone]);

        return $dataProvider;
    }
}
