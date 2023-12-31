<?php

use common\models\Course;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var app\models\CourseSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\common\Course $model */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>



        <div class="card">

            <img src="<?= Yii::$app->urlManager->createUrl('uploads/'.$model->file->name) ?>" class="card-img-top img-course-index" alt="..." >

            <div class="card-body">
                <span class="badge bg-primary"><?= $model->category->category_name ?></span>
                <span class="badge bg-danger text-end"><?= $model->skill_level ?></span>
                <h5 class="card-title"><?= $model->title ?> </h5>
                <p class="card-text"><?= $model->description ?></p>
                

                <?= Html::a('Ver Curso', ['course/view', 'id'=> $model->id, 'user_id'=> $model->user_id, 'category_id'=> $model->category_id, 'file_id'=> $model->file_id], ['class'=> 'btn btn-primary']) ?>

                <?= Html::a('Buy for ' .$model->price. '$',['course/additemcard', 'id' => $model->id], ['class' => 'btn btn-primary' ]) ?>
                <div class="float-end">

                    <?= Html::a('favorito',['course/addfavourite','id'=>$model->id],['class'=>'btn btn-primary'])?>
                </div>

            </div>
        </div>


