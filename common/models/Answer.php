<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property string|null $text
 * @property int|null $is_correct
 * @property int $questions_id
 * @property int $questions_quizzes_id
 *
 * @property Question $questions
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_correct', 'questions_id', 'questions_quizzes_id'], 'integer'],
            [['questions_id', 'questions_quizzes_id'], 'required'],
            [['text'], 'string', 'max' => 60],
            [['questions_id', 'questions_quizzes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::class, 'targetAttribute' => ['questions_id' => 'id', 'questions_quizzes_id' => 'quizzes_id']],
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
            'is_correct' => 'Is Correct',
            'questions_id' => 'Questions ID',
            'questions_quizzes_id' => 'Questions Quizzes ID',
        ];
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasOne(Question::class, ['id' => 'questions_id', 'quizzes_id' => 'questions_quizzes_id']);
    }
}
