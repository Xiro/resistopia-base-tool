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
    public $section;
    public $security_level;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid', 'forename', 'surname', 'nickname', 'name', 'gender', 'date_of_birth', 'profession', 'section', 'security_level', 'callsign', 'created', 'updated', 'blood_type_id'], 'safe'],
            [['height', 'status_alive', 'status_in_base', 'squat_number', 'access_key_id', 'rank_id', 'section_id', 'special_function_id', 'citizenship_id', 'eye_color_id', 'team_id'], 'integer'],
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
        $query->joinWith("section");
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
            'blood_type_id'       => $this->blood_type_id,
            'status_alive'        => $this->status_alive,
            'status_in_base'      => $this->status_in_base,
            'squat_number'        => $this->squat_number,
            'access_key_id'       => $this->access_key_id,
            'rank_id'             => $this->rank_id,
            'section_id'          => $this->section_id,
            'special_function_id' => $this->special_function_id,
            'citizenship_id'      => $this->citizenship_id,
            'eye_color_id'        => $this->eye_color_id,
            'team_id'             => $this->team_id,
        ]);

        $this->searchDates($query, [
            'date_of_birth' => $this->date_of_birth,
            'staff.created'       => $this->created,
            'staff.updated'       => $this->updated,
        ]);

//        $this->searchNear($query, [
//            'height'              => $this->height,
//        ]);

        $this->searchCaseInsensitive($query, [
            'sid'        => $this->sid,
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

        if($this->section) {
            $query->joinWith("section")
                ->andFilterWhere(['section.section' => $this->section]);
        }

        if($this->security_level) {
            $query->joinWith("securityLevel")
                ->andFilterWhere(['staff_security_level.security_level' => $this->security_level]);
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
            function (Staff $staff) {
                return $staff->isBlocked ? 'Blocked' : true;
            },
//            function (Staff $staff) {
//                return !$staff->status_in_base ? 'On Mission' : true;
//            },
        ];
    }
}
