<?php

use yii\helpers\Html;

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

    <?= $this->render('_form', [
        'model' => $model,
        'modelFile' => $modelFile,
        'modelCategory' => $modelCategory,
        'categoryList' => $categoryList,
        'modelUpload' => $modelUpload,
    ]) ?>

</div>
