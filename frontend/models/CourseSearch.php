<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Course;
use Yii;

/**
 * CourseSearch represents the model behind the search form of `common\models\Course`.
 */
class CourseSearch extends Course
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'skill_level', 'user_id', 'category_id', 'file_id'], 'integer'],
            [['title', 'description'], 'safe'],
            [['price'], 'number'],
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
        $query = Course::find();
        $userId = Yii::$app->user->id;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!Yii::$app->user->isGuest) {
            $query->leftJoin('favorite', 'course.id = favorite.courses_id AND favorite.user_id = :userId', [':userId' => $userId]);
            $query->andWhere(['OR', ['course.user_id' => $userId], ['favorite.user_id' => $userId]]);
            $query->orderBy(['favorite.id' => SORT_DESC, 'course.id' => SORT_DESC]);
        }

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (isset($params['courseIds']) && is_array($params['courseIds'])) {
            $query->andWhere(['in', 'course.id', $params['courseIds']]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'skill_level' => $this->skill_level,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'file_id' => $this->file_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
