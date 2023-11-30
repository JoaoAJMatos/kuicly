<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Course $model */
/** @var common\models\User $modelUser */
/** @var common\models\File $modelFile */
/** @var common\models\Category $modelCategory */
/** @var common\models\Category $categoryList */



$this->title = 'Create Course';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container py-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUser' => $modelUser,
        'modelFile' => $modelFile,
        'modelCategory' => $modelCategory,
        'categoryList' => $categoryList,
    ]) ?>

</div>
