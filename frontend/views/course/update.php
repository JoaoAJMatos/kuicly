<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Course $model */
/** @var common\models\User $modelUser */
/** @var common\models\File $modelFile */
/** @var common\models\Category $modelCategory */
/** @var common\models\Category $categoryList */
/** @var common\models\UploadForm $modelUpload */

$this->title = 'Update Course: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id, 'user_id' => $model->user_id, 'category_id' => $model->category_id, 'file_id' => $model->file_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container py-5">

    <h1><?= Html::encode($this->title) ?></h1>


        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'price')->textInput() ?>

        <?= $form->field($model, 'skill_level')->dropDownList(
            [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
            ],
            ['prompt' => 'Select Skill Level']
        ); ?>

        <?= $form->field($modelUpload, 'imageFile')->fileInput() ?>

        <?= $form->field($model, 'category_id')->dropDownList(
            $categoryList,
        ); ?>

        <?= Html::a('Add Lessons', ['lesson/create', 'id' => $model->id],['class' => 'btn btn-primary'] )?>
        <br>
        <br>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>



</div>
