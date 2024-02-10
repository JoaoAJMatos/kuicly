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

    <p>
        <?= Html::a('Create Quiz', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description',
            'time_limit:datetime',
            'number_questions',
            //'max_points',
            //'course_id',
            //'course_user_id',
            //'course_category_id',
            //'course_file_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Quiz $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id, 'course_id' => $model->course_id, 'course_user_id' => $model->course_user_id, 'course_category_id' => $model->course_category_id, 'course_file_id' => $model->course_file_id]);
                 }
            ],
        ],
    ]); ?>


</div>
