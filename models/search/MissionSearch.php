<?php

namespace app\models\search;

use app\helpers\DebugSql;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mission;

/**
 * MissionSearch represents the model behind the search form about `app\models\Mission`.
 */
class MissionSearch extends Mission
{
    use AdvancedSearchTrait;

    public $callsign;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'slots_total', 'slots_medic', 'slots_radio', 'slots_tech', 'slots_res', 'slots_guard', 'slots_vip', 'mission_status_id', 'operation_id', 'mission_type_id'], 'integer'],
            [['name', 'description', 'debrief_comment', 'note', 'zone', 'callsign', 'created_by_rpn', 'mission_lead_rpn', 'time_publish', 'time_lst', 'time_ete', 'time_atf', 'finished', 'created', 'updated'], 'safe'],
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
            'id'                => $this->id,
            'slots_total'       => $this->slots_total,
            'slots_medic'       => $this->slots_medic,
            'slots_radio'       => $this->slots_radio,
            'slots_tech'        => $this->slots_tech,
            'slots_res'         => $this->slots_res,
            'slots_guard'       => $this->slots_guard,
            'slots_vip'         => $this->slots_vip,
            'mission_status_id' => $this->mission_status_id,
            'operation_id'      => $this->operation_id,
            'mission_type_id'   => $this->mission_type_id,
            'time_atf'          => $this->time_atf,
        ]);

        $this->searchDates($query, [
            'time_publish' => $this->time_publish,
            'time_lst'     => $this->time_lst,
            'time_ete'     => $this->time_ete,
            'finished'     => $this->finished,
            'created'      => $this->created,
            'updated'      => $this->updated,
        ]);

        $this->searchCaseInsensitive($query, [
            'name'            => $this->name,
            'description'     => $this->description,
            'debrief_comment' => $this->debrief_comment,
            'note'            => $this->note,
        ]);

        $query->andFilterWhere(['like', 'zone', $this->zone])
            ->andFilterWhere(['like', 'created_by_rpn', $this->created_by_rpn])
            ->andFilterWhere(['like', 'mission_lead_rpn', $this->mission_lead_rpn]);

        if ($this->callsign) {
            $query->joinWith('staff')
                ->andFilterWhere(['like', 'staff.callsign', $this->callsign]);
        }

        return $dataProvider;
    }
}
