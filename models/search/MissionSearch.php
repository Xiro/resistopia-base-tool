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

    public $call_sign;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'RP', 'FP', 'mission_type_id', 'mission_status_id'], 'integer'],
            [['name', 'description', 'zone', 'started', 'ended', 'debrief_comment', 'call_sign'], 'safe'],
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
        if(isset($params["MissionSearch"])) {
            $params = $params["MissionSearch"];
        }
        $this->setAttributes($params);

        $query = $this->searchQuery();

        $query->groupBy("mission.id");

        $dataProvider = new ActiveDataProvider([
            "query" => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }

    public function searchQuery($exclude = null)
    {
        $query = Mission::find();

        if ($this->name) {
            $parts = explode(" ", $this->name);
            $where = ["or"];
            foreach ($parts as $part) {
                $where[] = "forename LIKE '%$part%'";
                $where[] = "surname LIKE '%$part%'";
                $where[] = "nickname LIKE '%$part%'";
            }
            $query->andWhere($where);
        }
        if ($this->mission_status_id) {
            $query->andWhere(["mission_status_id" => $this->mission_status_id]);
        }
        if ($this->mission_type_id) {
            $query->andWhere(["mission_type_id" => $this->mission_type_id]);
        }
        if ($this->zone) {
            $query->andWhere(["zone" => $this->zone]);
        }
        if ($this->description) {
            $query->andWhere("description LIKE '%" . $this->description. "%'");
        }
        if ($this->debrief_comment) {
            $query->andWhere("debrief_comment LIKE '%" . $this->debrief_comment. "%'");
        }
        if ($this->RP) {
            $query->andWhere("RP LIKE '%" . $this->RP. "%'");
        }
        if ($this->FP) {
            $query->andWhere("FP LIKE '%" . $this->FP. "%'");
        }
        if ($this->started) {
            $from = date("Y-m-d\TH:i:s", strtotime($this->started) - 60 * 30);
            $to = date("Y-m-d\TH:i:s", strtotime($this->started) + 60 * 30);
            $query->andWhere([
                "and",
                [">=", "started", $from],
                ["<=", "started", $to],
            ]);
        }
        if ($this->call_sign) {
            $query->joinWith("staff");
            $query->andWhere(["staff.call_sign" => $this->call_sign]);
        }

        return $query;
    }
}
