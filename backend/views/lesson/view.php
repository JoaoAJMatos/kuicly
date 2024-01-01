<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Lesson $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Lessons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lesson-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'sections_id' => $model->sections_id, 'quizzes_id' => $model->quizzes_id, 'file_id' => $model->file_id, 'lesson_type_id' => $model->lesson_type_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'sections_id' => $model->sections_id, 'quizzes_id' => $model->quizzes_id, 'file_id' => $model->file_id, 'lesson_type_id' => $model->lesson_type_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'context',
            'sections_id',
            'quizzes_id',
            'file_id',
            'lesson_type_id',
        ],
    ]) ?>

    <video id='myVideo' width="640" height="360" controls autoplay src="<?= Yii::$app->urlManager->createUrl('uploads/'.$model->file->name) ?>" style="border: 1px solid black"></video>
</div>
