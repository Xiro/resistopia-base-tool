<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MissionBlock;

/**
 * MissionBlockSearch represents the model behind the search form about `app\models\MissionBlock`.
 */
class MissionBlockSearch extends MissionBlock
{

    public $blocked_staff_member;
    public $blocked_by;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['blocked_staff_member_rpn', 'blocked_by_rpn', 'blocked_staff_member', 'blocked_by', 'unblock_time', 'created'], 'safe'],
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
        $query = MissionBlock::find();

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
            'unblock_time' => $this->unblock_time,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'blocked_staff_member_rpn', $this->blocked_staff_member_rpn])
            ->andFilterWhere(['like', 'blocked_by_rpn', $this->blocked_by_rpn]);

        if($this->blocked_staff_member) {
            $nameParts = explode(' ', $this->blocked_staff_member);
            $query->leftJoin('staff as blockedStaff', 'blocked_staff_member_rpn = blockedStaff.rpn');
            $query->andFilterWhere(['or',
                ['like', 'blockedStaff.forename', $nameParts],
                ['like', 'blockedStaff.surname', $nameParts],
                ['like', 'blockedStaff.nickname', $nameParts],
                ['like', 'blockedStaff.rpn', $nameParts],
            ]);
        }

        if($this->blocked_by) {
            $nameParts = explode(' ', $this->blocked_by);
            $query->leftJoin('staff as blockedBy', 'blocked_by_rpn = blockedBy.rpn');
            $query->andFilterWhere(['or',
                ['like', 'blockedBy.forename', $nameParts],
                ['like', 'blockedBy.surname', $nameParts],
                ['like', 'blockedBy.nickname', $nameParts],
                ['like', 'blockedBy.rpn', $nameParts],
            ]);
        }

        return $dataProvider;
    }
}
