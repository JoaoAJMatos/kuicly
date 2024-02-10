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

    <?= $form->field($model, 'option_one')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'option_two')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'option_three')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'option_four')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correct_answer')->dropDownList([ '1' => 'Option 1', '2' => 'Option 2', '3' => 'Option 3','4' => 'Option 4' ]) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
