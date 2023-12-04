<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property string|null $text
 * @property string|null $type
 * @property string|null $correct_answer
 * @property int $quizzes_id
 *
 * @property Answer[] $answers
 * @property Quiz $quizzes
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'correct_answer'], 'string'],
            [['quizzes_id'], 'required'],
            [['quizzes_id'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['quizzes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quiz::class, 'targetAttribute' => ['quizzes_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'type' => 'Type',
            'correct_answer' => 'Correct Answer',
            'quizzes_id' => 'Quizzes ID',
        ];
    }

    /**
     * Gets query for [[Answers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::class, ['questions_id' => 'id', 'questions_quizzes_id' => 'quizzes_id']);
    }

    /**
     * Gets query for [[Quizzes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuizzes()
    {
        return $this->hasOne(Quiz::class, ['id' => 'quizzes_id']);
    }
}
