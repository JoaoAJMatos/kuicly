<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Lesson $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\Lesson $modelSection */
/** @var common\models\Lesson $sectionList */
/** @var common\models\LessonType $lessonTypeList */
/** @var common\models\LessonType $quizList */
/** @var common\models\Lesson $modelFile */
/** @var common\models\UploadForm $modelUpload */
/** @var common\models\Lesson $id */


?>

<div class="lesson-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'context')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sections_id')->dropDownList(
        $sectionList,
        ['prompt' => 'Select Section']
    ); ?>

    <?= Html::a('Create Section',['section/create','id'=>$id],['class'=> 'btn btn-primary'])?>

    <?= $form->field($model, 'lesson_type_id')->dropDownList(
            $lessonTypeList,
        ['prompt' => 'Select Lesson Type']
    ); ?>

    <?= $form->field($modelUpload, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'quiz_id')->dropDownList(
        $quizList,
        ['prompt' => 'Select Quiz']
    ); ?>

    <?= Html::a('Create Quiz',['quiz/create','course_id'=>$id],['class'=> 'btn btn-primary'])?>

    <br>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    const VIDEO = 15;
    const QUIZ = 16;

    const select = document.getElementById('lesson-lesson_type_id');
    const selection = parseInt(select.value, 10);

    if (selection === VIDEO){

        document.getElementsByClassName('field-lesson-quiz_id')[0].style.display = 'none';
        document.getElementsByClassName('btn btn-primary')[2].style.visibility = 'hidden';
        document.getElementsByClassName('field-uploadform-imagefile')[0].style.display = 'block';
    } else if(selection === QUIZ){

        document.getElementsByClassName('field-uploadform-imagefile')[0].style.display = 'none';
        document.getElementsByClassName('field-lesson-quiz_id')[0].style.display = 'block';
        document.getElementsByClassName('btn btn-primary')[2].style.visibility = 'visible';
    }else {
        document.getElementsByClassName('field-lesson-quiz_id')[0].style.display = 'none';
        document.getElementsByClassName('btn btn-primary')[2].style.visibility = 'hidden';
        document.getElementsByClassName('field-uploadform-imagefile')[0].style.display = 'none';
    }

    select.addEventListener('change', (event) => {
        const selection = parseInt(event.target.value, 10);
        console.log(selection);
        console.log(VIDEO);
        if (selection === VIDEO){

            document.getElementsByClassName('field-lesson-quiz_id')[0].style.display = 'none';
            document.getElementsByClassName('btn btn-primary')[2].style.visibility = 'hidden';
            document.getElementsByClassName('field-uploadform-imagefile')[0].style.display = 'block';
        } else if(selection === QUIZ){

            document.getElementsByClassName('field-uploadform-imagefile')[0].style.display = 'none';
            document.getElementsByClassName('field-lesson-quiz_id')[0].style.display = 'block';
            document.getElementsByClassName('btn btn-primary')[2].style.visibility = 'visible';
        }
    });

</script>
