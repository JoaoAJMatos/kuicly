<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Course $model */
/** @var common\models\User $modelUser */
/** @var common\models\File $modelFile */
/** @var common\models\Category $modelCategory */
/** @var common\models\Category $categoryList*/
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\UploadForm $modelUpload */
?>

<div class="">

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

    <br>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
