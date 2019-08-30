<?php

namespace app\models\search;

use app\helpers\DebugSql;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MedicineCheckup;

/**
 * MedicineCheckupSearch represents the model behind the search form about `app\models\MedicineCheckup`.
 */
class MedicineCheckupSearch extends MedicineCheckup
{
    use AdvancedSearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pulse', 'temperature', 'blood_pressure_systolic', 'blood_pressure_diastolic'], 'integer'],
            [['author_sid', 'patient_sid', 'impairment', 'aftercare', 'breathing', 'breathing_details', 'pupils', 'nutrition', 'psyche', 'complexion', 'vaccinations', 'conditions', 'drug_use', 'other', 'created', 'updated'], 'safe'],
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

        $this->searchCaseInsensitive($query, [
            'author_sid' => $this->author_sid,
            'patient_sid' => $this->patient_sid,
            'impairment' => $this->impairment,
            'aftercare' => $this->aftercare,
            'breathing' => $this->breathing,
            'breathing_details' => $this->breathing_details,
            'pupils' => $this->pupils,
            'nutrition' => $this->nutrition,
            'psyche' => $this->psyche,
            'complexion' => $this->complexion,
            'vaccinations' => $this->vaccinations,
            'conditions' => $this->conditions,
            'drug_use' => $this->drug_use,
            'other' => $this->other,
        ]);

        $this->searchDates($query, [
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'pulse' => $this->pulse,
            'temperature' => $this->temperature,
            'blood_pressure_systolic' => $this->blood_pressure_systolic,
            'blood_pressure_diastolic' => $this->blood_pressure_diastolic,
        ]);

        return $dataProvider;
    }
}
