<?php

use common\models\Course;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CourseSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'
            ],

            'id',
            'title',
            'description',
            'price',
            'skill_level',
            //'user_id',
            //'category_id',
            //'file_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete} {myButton} ',
                'buttons' => [
                    'myButton' => function($url, $model, $key) {     // render your custom button
                        return Html::a('Lessons', Url::to(['course/lessons', 'course_id' => $model->id]), ['class' => 'btn btn-success']);
                    }
                ],
            ],

        ],
    ]); ?>




</div>
