<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Lesson $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\Lesson $modelSection */
/** @var common\models\Lesson $sectionList */
/** @var common\models\LessonType $lessonTypeList */
/** @var common\models\Lesson $modelFile */
/** @var common\models\UploadForm $modelUpload */


?>

<div class="lesson-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'context')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sections_id')->dropDownList(
        $sectionList,
        ['prompt' => 'Select Section']
    ); ?>



    <?= $form->field($model, 'lesson_type_id')->dropDownList(
            $lessonTypeList,
        ['prompt' => 'Select Lesson Type']
    ); ?>

    <?= $form->field($modelUpload, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'quizzes_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
