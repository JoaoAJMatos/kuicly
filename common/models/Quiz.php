<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quiz".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $time_limit
 * @property int|null $number_questions
 * @property int|null $max_points
 *
 * @property Lesson[] $lessons
 * @property Question[] $questions
 */
class Quiz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time_limit', 'number_questions', 'max_points'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'time_limit' => 'Time Limit',
            'number_questions' => 'Number Questions',
            'max_points' => 'Max Points',
        ];
    }

    /**
     * Gets query for [[Lessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLessons()
    {
        return $this->hasMany(Lesson::class, ['quizzes_id' => 'id']);
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::class, ['quizzes_id' => 'id']);
    }
}
