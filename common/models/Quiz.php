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
 * @property int $course_id
 * @property int $course_user_id
 * @property int $course_category_id
 * @property int $course_file_id
 *
 * @property Course $course
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
            [['time_limit', 'number_questions', 'max_points', 'course_id', 'course_user_id', 'course_category_id', 'course_file_id'], 'integer'],
            [['course_id', 'course_user_id', 'course_category_id', 'course_file_id'], 'required'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['course_id', 'course_user_id', 'course_category_id', 'course_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id', 'course_user_id' => 'user_id', 'course_category_id' => 'category_id', 'course_file_id' => 'file_id']],
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
            'course_id' => 'Course ID',
            'course_user_id' => 'Course User ID',
            'course_category_id' => 'Course Category ID',
            'course_file_id' => 'Course File ID',
        ];
    }

    /**
     * Gets query for [[Course]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::class, ['id' => 'course_id', 'user_id' => 'course_user_id', 'category_id' => 'course_category_id', 'file_id' => 'course_file_id']);
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
