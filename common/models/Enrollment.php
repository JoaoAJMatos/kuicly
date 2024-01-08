<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "enrollment".
 *
 * @property int $id
 * @property string|null $enrollment_date
 * @property string|null $status
 * @property int $user_id
 * @property int $courses_id
 *
 * @property Course $courses
 * @property User $user
 */
class Enrollment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'enrollment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enrollment_date'], 'safe'],
            [['status'], 'string'],
            [['user_id', 'courses_id'], 'required'],
            [['user_id', 'courses_id'], 'integer'],
            [['courses_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['courses_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'enrollment_date' => 'Enrollment Date',
            'status' => 'Status',
            'user_id' => 'User ID',
            'courses_id' => 'Courses ID',
        ];
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasOne(Course::class, ['id' => 'courses_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
