<?php

use common\models\Course;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var app\models\CourseSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container py-5">


    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Course', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<br>

    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?php
        $selector = \yii\helpers\ArrayHelper::getValue($_GET,'sort','-title');
        ?>
        Sort by: <?= Html::dropDownList('sortDropdowm',$selector, ['' => '--Select--','title' => 'Name Asc', '-title'=>'Name Desc','-skill_level' => 'Dificulty Asc','skill_level' =>'Dificulty Desc']) ?>
    </p>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_list',
            'options' => [
                'class' => 'row row-cols-1 row-cols-md-3 g-3',
            ],
            'itemOptions' => [
                'class' => 'col',
            ],
        ]);
        ?>


</div>