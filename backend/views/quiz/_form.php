<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Quiz $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quiz-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_limit')->textInput() ?>

    <?= $form->field($model, 'number_questions')->textInput() ?>

    <?= $form->field($model, 'max_points')->textInput() ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <?= $form->field($model, 'course_user_id')->textInput() ?>

    <?= $form->field($model, 'course_category_id')->textInput() ?>

    <?= $form->field($model, 'course_file_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
