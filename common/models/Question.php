<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property string $text
 * @property string|null $type
 * @property string|null $option_one
 * @property string|null $option_two
 * @property string|null $option_three
 * @property string|null $option_four
 * @property int $correct_answer
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
            [['text', 'correct_answer', 'quizzes_id'], 'required'],
            [['type'], 'string'],
            [['correct_answer', 'quizzes_id'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['option_one', 'option_two', 'option_three', 'option_four'], 'string', 'max' => 45],
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
            'option_one' => 'Option One',
            'option_two' => 'Option Two',
            'option_three' => 'Option Three',
            'option_four' => 'Option Four',
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
