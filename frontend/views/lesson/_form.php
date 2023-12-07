<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Lesson $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\Lesson $modelSection */
/** @var common\models\Lesson $sectionList */

?>

<div class="lesson-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'Video' => 'Video', 'Texto' => 'Texto', 'Quiz' => 'Quiz', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'context')->textInput(['maxlength' => true]) ?>

    <?php /*= $form->field($model, 'sections_id')->textInput() */?>

    <?= $form->field($model, 'sections_id')->dropDownList(
        $sectionList,
        ['prompt' => 'Select Section']
    ); ?>

    <?= $form->field($model, 'quizzes_id')->textInput() ?>

    <?= $form->field($model, 'file_id')->textInput() ?>

    <?= $form->field($model, 'lesson_type_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
