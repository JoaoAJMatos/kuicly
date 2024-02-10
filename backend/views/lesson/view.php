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
        <?php if($model->lessonType->type == 'Quiz') { ?>
        <?=  Html::a('Quiz',['quiz/view', 'id'=>$model->quiz->id,'course_id'=>$model->quiz->course_id,'course_user_id'=>$model->quiz->course_user_id,'course_category_id'=>$model->quiz->course_category_id,'course_file_id'=>$model->quiz->course_file_id],['class'=> 'btn btn-primary']) ?>
        <?php } ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'sections_id' => $model->sections_id, 'quizzes_id' => $model->quizzes_id, 'file_id' => $model->file_id, 'lesson_type_id' => $model->lesson_type_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php
    $attributes = [
    'id',
    'title',
    'context',
    [
    'attribute' => 'sections_id',
    'value' => function ($model) {
    return $model->sections->title;
    },
    ],
    [
    'attribute' => 'lesson_type_id',
    'value' => function ($model) {
    return $model->lessonType->type;
    },
    ],
    ];

    if ($model->lessonType->type == 'video') {
    $attributes[] = [
    'attribute' => 'file_id',
    'value' => function ($model) {
    return $model->file->name;
    },
    ];
    } else {
    $attributes[] = [
    'attribute' => 'quizzes_id',
    'value' => function ($model) {
    return $model->quizzes->title;
    },
    ];
    }

    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>


    <video id='myVideo' width="640" height="360" controls autoplay src=" <?php var_dump(Yii::getAlias('@web') . '/../../frontend/upload/'.$model->file->name); ?> " style="border: 1px solid black"></video> );
    die();
    ?>" style="border: 1px solid black"></video>
</div>
