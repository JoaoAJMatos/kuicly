<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Question $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'MULTIPLE_CHOICE' => 'MULTIPLE CHOICE', 'SHORT_ANSWER' => 'SHORT ANSWER', 'TRUE_FALSE' => 'TRUE FALSE', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'option_one')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'option_two')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'option_three')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'option_four')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correct_answer')->textInput() ?>

    <?= $form->field($model, 'quizzes_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
