<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StaffFileMemo;

/**
 * StaffFileMemoSearch represents the model behind the search form about `app\models\StaffFileMemo`.
 */
class StaffFileMemoSearch extends StaffFileMemo
{

    public $staff_name;
    public $author_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'access_right_id'], 'integer'],
            [['title', 'file_memo', 'rpn', 'staff_name', 'author_rpn', 'author_name', 'created', 'updated'], 'safe'],
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
        $query = StaffFileMemo::find();

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
            'access_right_id' => $this->access_right_id,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'file_memo', $this->file_memo])
            ->andFilterWhere(['like', 'rpn', $this->rpn])
            ->andFilterWhere(['like', 'author_rpn', $this->author_rpn]);

        if($this->staff_name) {
            $nameParts = explode(' ', $this->staff_name);
            $query->joinWith('staff');
            $query->andFilterWhere(['or',
                ['like', 'staff.forename', $nameParts],
                ['like', 'staff.surname', $nameParts],
                ['like', 'staff.nickname', $nameParts],
                ['like', 'staff.rpn', $nameParts],
            ]);
        }

        if($this->author_name) {
            $nameParts = explode(' ', $this->author_name);
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
