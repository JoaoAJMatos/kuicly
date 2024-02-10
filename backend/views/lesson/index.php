<?php

use common\models\Lesson;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\LessonSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lessons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'context',
            [
                'attribute' => 'sections_id',
                'value' => function ($model) {
                    return $model->sections->title; // Supondo que 'name' seja o atributo que armazena o nome da seção.
                },
            ],

            //'file_id',
            //'lesson_type_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}  ',

            ],
        ],
    ]); ?>


</div>
