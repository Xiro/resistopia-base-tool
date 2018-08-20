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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'access_right_id'], 'integer'],
            [['title', 'file_memo', 'rpn', 'author_rpn', 'created', 'updated'], 'safe'],
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

        return $dataProvider;
    }
}
