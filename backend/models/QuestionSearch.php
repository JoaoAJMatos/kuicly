<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Question;

/**
 * QuestionSearch represents the model behind the search form of `common\models\Question`.
 */
class QuestionSearch extends Question
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'correct_answer', 'quizzes_id'], 'integer'],
            [['text', 'type', 'option_one', 'option_two', 'option_three', 'option_four'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Question::find();

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
            'correct_answer' => $this->correct_answer,
            'quizzes_id' => $this->quizzes_id,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'option_one', $this->option_one])
            ->andFilterWhere(['like', 'option_two', $this->option_two])
            ->andFilterWhere(['like', 'option_three', $this->option_three])
            ->andFilterWhere(['like', 'option_four', $this->option_four]);

        return $dataProvider;
    }
}
