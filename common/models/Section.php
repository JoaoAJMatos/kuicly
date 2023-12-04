<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "section".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $order
 * @property int $courses_id
 * @property int $user_id
 * @property int $category_id
 *
 * @property Course $courses
 * @property Lesson[] $lessons
 */
class Section extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order', 'courses_id', 'user_id', 'category_id'], 'integer'],
            [['courses_id', 'user_id', 'category_id'], 'required'],
            [['title'], 'string', 'max' => 70],
            [['courses_id', 'user_id', 'category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['courses_id' => 'id', 'user_id' => 'user_id', 'category_id' => 'category_id']],
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
            'order' => 'Order',
            'courses_id' => 'Courses ID',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasOne(Course::class, ['id' => 'courses_id', 'user_id' => 'user_id', 'category_id' => 'category_id']);
    }

    /**
     * Gets query for [[Lessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLessons()
    {
        return $this->hasMany(Lesson::class, ['sections_id' => 'id']);
    }
}
