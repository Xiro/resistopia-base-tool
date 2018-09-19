<?php

namespace app\models\search;

use app\helpers\DebugSql;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Staff;
use yii\db\ActiveQuery;

/**
 * StaffSearch represents the model behind the search form about `app\models\Staff`.
 */
class StaffSearch extends Staff
{
    use AdvancedSearchTrait;

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
        $query->joinWith("team");
        $query->joinWith("baseCategory");
        $query->joinWith("specialFunction");

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
            'height'              => $this->height,
            'status_it'           => $this->status_it,
            'status_be13'         => $this->status_be13,
            'status_alive'        => $this->status_alive,
            'status_in_base'      => $this->status_in_base,
            'squat_number'        => $this->squat_number,
            'access_key_id'       => $this->access_key_id,
            'rank_id'             => $this->rank_id,
            'base_category_id'    => $this->base_category_id,
            'special_function_id' => $this->special_function_id,
            'company_id'          => $this->company_id,
            'citizenship_id'      => $this->citizenship_id,
            'eye_color_id'        => $this->eye_color_id,
            'team_id'             => $this->team_id,
        ]);

        $this->searchDates($query, [
            'date_of_birth' => $this->date_of_birth,
            'created'       => $this->created,
            'updated'       => $this->updated,
        ]);

        $this->searchCaseInsensitive($query, [
            'rpn'        => $this->rpn,
            'forename'   => $this->forename,
            'surname'    => $this->surname,
            'nickname'   => $this->nickname,
            'gender'     => $this->gender,
            'profession' => $this->profession,
            'callsign'   => $this->callsign,
        ]);

        if ($this->name) {
            $this->searchFulltext(
                $query,
                $this->name,
                ['forename', 'surname', 'nickname']
            );
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @param null $missionId
     * @return ActiveDataProvider
     */
    public function searchMissionForm($params, $missionId = null)
    {
        $dataProvider = $this->search($params);

        if ($missionId) {
            /** @var ActiveQuery $query */
            $query = $dataProvider->query;
            $query->joinWith('missions')
                ->andWhere([
                    'or',
                    ['!=', 'mission.id', $missionId],
                    ['mission.id' => null]
                ]);
        }

        return $dataProvider;
    }

    public function getMissionActionEnableValidators()
    {
        return [
//            function (Staff $staff) {
////                var_dump($staff->status_alive);
//                return $staff->status_alive === 0 ? 'Dead' : true;
//            },
////            function (Staff $staff) {
////                return !$staff->status_it ? 'OT' : true;
////            },
            function (Staff $staff) {
                return $staff->isBlocked ? 'Blocked' : true;
            },
//            function (Staff $staff) {
//                return !$staff->status_in_base ? 'On Mission' : true;
//            },
////            function (Staff $staff) {
////                return !$staff->status_be13 ? 'Not BE13' : true;
////            },
        ];
    }
}
