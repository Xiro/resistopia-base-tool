<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MedicineCheckup;

/**
 * MedicineCheckupSearch represents the model behind the search form about `app\models\MedicineCheckup`.
 */
class MedicineCheckupSearch extends MedicineCheckup
{

    public $patient;
    public $author;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pulse', 'temperature', 'blood_pressure_systolic', 'blood_pressure_diastolic'], 'integer'],
            [['author', 'patient', 'author_rpn', 'patient_rpn', 'impairment', 'aftercare', 'breathing', 'breathing_details', 'pupils', 'nutrition', 'psyche', 'complexion', 'vaccinations', 'conditions', 'drug_use', 'other', 'created', 'updated'], 'safe'],
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
        $query = MedicineCheckup::find();

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
            'pulse' => $this->pulse,
            'temperature' => $this->temperature,
            'blood_pressure_systolic' => $this->blood_pressure_systolic,
            'blood_pressure_diastolic' => $this->blood_pressure_diastolic,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'author_rpn', $this->author_rpn])
            ->andFilterWhere(['like', 'patient_rpn', $this->patient_rpn])
            ->andFilterWhere(['like', 'impairment', $this->impairment])
            ->andFilterWhere(['like', 'aftercare', $this->aftercare])
            ->andFilterWhere(['like', 'breathing', $this->breathing])
            ->andFilterWhere(['like', 'breathing_details', $this->breathing_details])
            ->andFilterWhere(['like', 'pupils', $this->pupils])
            ->andFilterWhere(['like', 'nutrition', $this->nutrition])
            ->andFilterWhere(['like', 'psyche', $this->psyche])
            ->andFilterWhere(['like', 'complexion', $this->complexion])
            ->andFilterWhere(['like', 'vaccinations', $this->vaccinations])
            ->andFilterWhere(['like', 'conditions', $this->conditions])
            ->andFilterWhere(['like', 'drug_use', $this->drug_use])
            ->andFilterWhere(['like', 'other', $this->other]);

        if($this->patient) {
            $nameParts = explode(' ', $this->patient);
            $query->leftJoin('staff as patient', 'patient_rpn = patient.rpn');
            $query->andFilterWhere(['or',
                ['like', 'patient.forename', $nameParts],
                ['like', 'patient.surname', $nameParts],
                ['like', 'patient.nickname', $nameParts],
                ['like', 'patient.rpn', $nameParts],
            ]);
        }

        if($this->author) {
            $nameParts = explode(' ', $this->author);
            $query->leftJoin('staff as author', 'author_rpn = author.rpn');
            $query->andFilterWhere(['or',
                ['like', 'author.forename', $nameParts],
                ['like', 'author.surname', $nameParts],
                ['like', 'author.nickname', $nameParts],
                ['like', 'author.rpn', $nameParts],
            ]);
        }

        return $dataProvider;
    }
}
