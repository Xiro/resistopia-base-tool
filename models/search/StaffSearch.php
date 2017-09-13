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
            [[
                'id',
                'height',
                'company_id',
                'category_id',
                'speciality_id',
                'rank_id',
                'team_id',
                'blood_type_id',
                'eye_color_id',
                'staff_status_id'
            ], 'integer'],
            [[
                'rpn',
                'forename',
                'surname',
                'nickname',
                'name',
                'profession',
                'password',
                'created',
                'updated',
                'died',
                'call_sign',
                'is_blocked',
                'is_it'
            ], 'safe'],
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
        if(isset($params["StaffSearch"])) {
            $params = $params["StaffSearch"];
        }
        $this->setAttributes($params);

        $query = $this->searchQuery();

        $query->groupBy("staff.id");

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
        $query = Staff::find();

        if ($this->rpn) {
            $query->andWhere("rpn LIKE '%" . $this->rpn. "%'");
        }
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
        if ($this->category_id) {
            $query->andWhere(["category_id" => $this->category_id]);
        }
        if ($this->speciality_id) {
            $query->andWhere(["speciality_id" => $this->speciality_id]);
        }
        if ($this->team_id) {
            $query->andWhere(["team_id" => $this->team_id]);
        }
        if ($this->staff_status_id) {
            $query->andWhere(["staff_status_id" => $this->staff_status_id]);
        }
        if ($this->call_sign) {
            $query->andWhere(["call_sign" => $this->call_sign]);
        }
        return $query;
    }
}
