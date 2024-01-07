<?php

use common\models\Quiz;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\QuizSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Quizzes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'description',
            'time_limit:datetime',
            'number_questions',
            //'max_points',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete} {questions}',
                'buttons' => [
                    'questions' => function($url, $model, $key) {     // render your custom button
                        return Html::a('<i class="bi bi-list"></i>Questions', Url::to(['question/index', 'id' => $model->id]), ['class' => 'btn btn-success']);
                    }
                ],
            ],
        ],
    ]); ?>


</div>
