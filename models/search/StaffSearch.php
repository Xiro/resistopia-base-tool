<?php

namespace app\models\search;

use app\helpers\DebugSql;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Staff;

/**
 * StaffSearch represents the model behind the search form about `app\models\Staff`.
 */
class StaffSearch extends Staff
{

    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rpn', 'forename', 'surname', 'nickname', 'name', 'gender', 'date_of_birth', 'profession', 'callsign', 'created', 'updated'], 'safe'],
            [['height', 'status_it', 'status_be13', 'status_alive', 'status_in_base', 'squat_number', 'access_key_id', 'rank_id', 'base_category_id', 'special_function_id', 'company_id', 'citizenship_id', 'eye_color_id', 'team_id'], 'integer'],
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
            'date_of_birth' => $this->date_of_birth,
            'height' => $this->height,
            'status_it' => $this->status_it,
            'status_be13' => $this->status_be13,
            'status_alive' => $this->status_alive,
            'status_in_base' => $this->status_in_base,
            'squat_number' => $this->squat_number,
            'access_key_id' => $this->access_key_id,
            'rank_id' => $this->rank_id,
            'base_category_id' => $this->base_category_id,
            'special_function_id' => $this->special_function_id,
            'company_id' => $this->company_id,
            'citizenship_id' => $this->citizenship_id,
            'eye_color_id' => $this->eye_color_id,
            'team_id' => $this->team_id,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'rpn', $this->rpn])
            ->andFilterWhere(['like', 'forename', $this->forename])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'profession', $this->profession])
            ->andFilterWhere(['like', 'callsign', $this->callsign]);

        if($this->name) {
            // @ToDo: Implement name search
            $nameParts = explode(' ', $this->name);
            $query->andFilterWhere(['or',
                ['like', 'forename', $nameParts],
                ['like', 'surname', $nameParts],
                ['like', 'nickname', $nameParts],
            ]);
        }

        return $dataProvider;
    }
}
