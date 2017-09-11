<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Staff;

/**
 * StaffSearch represents the model behind the search form about `app\models\Staff`.
 */
class StaffSearch extends Staff
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'height', 'company_id', 'category_id', 'speciality_id', 'rank_id', 'team_id', 'blood_type_id', 'eye_color_id', 'staff_status_id'], 'integer'],
            [['rpn', 'forename', 'surname', 'nickname', 'profession', 'password', 'created', 'updated', 'died', 'call_sign', 'is_blocked', 'is_it'], 'safe'],
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
        $query = Staff::find();

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
            'height' => $this->height,
            'created' => $this->created,
            'updated' => $this->updated,
            'died' => $this->died,
            'company_id' => $this->company_id,
            'category_id' => $this->category_id,
            'speciality_id' => $this->speciality_id,
            'rank_id' => $this->rank_id,
            'team_id' => $this->team_id,
            'blood_type_id' => $this->blood_type_id,
            'eye_color_id' => $this->eye_color_id,
            'staff_status_id' => $this->staff_status_id,
        ]);

        $query->andFilterWhere(['like', 'rpn', $this->rpn])
            ->andFilterWhere(['like', 'forename', $this->forename])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'profession', $this->profession])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'call_sign', $this->call_sign])
            ->andFilterWhere(['like', 'is_blocked', $this->is_blocked])
            ->andFilterWhere(['like', 'is_it', $this->is_it]);

        return $dataProvider;
    }
}
