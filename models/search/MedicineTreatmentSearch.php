<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MedicineTreatment;

/**
 * MedicineTreatmentSearch represents the model behind the search form about `app\models\MedicineTreatment`.
 */
class MedicineTreatmentSearch extends MedicineTreatment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pulse', 'temperature', 'blood_pressure_systolic', 'blood_pressure_diastolic'], 'integer'],
            [['author_rpn', 'patient_rpn', 'impairment', 'aftercare', 'operational_fitness', 'breathing', 'breathing_details', 'pupils', 'psyche', 'pretreatment', 'medi_foam', 'annotation', 'created', 'updated'], 'safe'],
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
        $query = MedicineTreatment::find();

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
            ->andFilterWhere(['like', 'operational_fitness', $this->operational_fitness])
            ->andFilterWhere(['like', 'breathing', $this->breathing])
            ->andFilterWhere(['like', 'breathing_details', $this->breathing_details])
            ->andFilterWhere(['like', 'pupils', $this->pupils])
            ->andFilterWhere(['like', 'psyche', $this->psyche])
            ->andFilterWhere(['like', 'pretreatment', $this->pretreatment])
            ->andFilterWhere(['like', 'medi_foam', $this->medi_foam])
            ->andFilterWhere(['like', 'annotation', $this->annotation]);

        return $dataProvider;
    }
}
