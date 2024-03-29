<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lesson".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $context
 * @property int $sections_id
 * @property int $lesson_type_id
 * @property int|null $quiz_id
 * @property int|null $file_id
 *
 * @property CompletedLesson[] $completedLessons
 * @property File $file
 * @property LessonType $lessonType
 * @property Note[] $notes
 * @property Quiz $quiz
 * @property Section $sections
 */
class Lesson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lesson';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sections_id', 'lesson_type_id'], 'required'],
            [['sections_id', 'lesson_type_id', 'quiz_id', 'file_id'], 'integer'],
            [['title'], 'string', 'max' => 70],
            [['context'], 'string', 'max' => 100],
            [['sections_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::class, 'targetAttribute' => ['sections_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
            [['lesson_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LessonType::class, 'targetAttribute' => ['lesson_type_id' => 'id']],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::class, 'targetAttribute' => ['quiz_id' => 'id']],
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
            'context' => 'Context',
            'sections_id' => 'Sections',
            'lesson_type_id' => 'Lesson Type',
            'quiz_id' => 'Quiz',
            'file_id' => 'File',
        ];
    }

    /**
     * Gets query for [[CompletedLessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompletedLessons()
    {
        return $this->hasMany(CompletedLesson::class, ['lessons_id' => 'id', 'sections_id' => 'sections_id']);
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'file_id']);
    }

    /**
     * Gets query for [[LessonType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLessonType()
    {
        return $this->hasOne(LessonType::class, ['id' => 'lesson_type_id']);
    }

    /**
     * Gets query for [[Notes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->hasMany(Note::class, ['lessons_id' => 'id']);
    }

    /**
     * Gets query for [[Quiz]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(Quiz::class, ['id' => 'quiz_id']);
    }

    /**
     * Gets query for [[Sections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasOne(Section::class, ['id' => 'sections_id']);
    }
}
