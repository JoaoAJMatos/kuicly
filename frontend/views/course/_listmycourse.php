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
$userId = Yii::$app->user->id;
$isFavorito = \common\models\Favorite::find()->where(['courses_id' => $model->id, 'user_id' => Yii::$app->user->id])->exists();

$buttonClass = $isFavorito ? 'btn btn-favorito' : 'btn btn-outline-favorito';
$iconClass = $isFavorito ? 'bi-star-fill' : 'bi-star';
?>



<div class="card">

    <!--<img src="<?php /*= 'uploads/'.$model->file->path */?>" class="card-img-top" alt="...">-->
    <img src="<?= Yii::$app->urlManager->createUrl('uploads/'. $model->file->name) ?>" class="card-img-top img-course-index" alt="...">
    <?php /*=  Html::img('img/topgbacano',['class'=>'card-img-top'])   */?>
    <div class="card-body">

        <span class="badge bg-primary"><?= $model->category->category_name ?></span>
        <span class="badge bg-danger text-end"><?= $model->skill_level ?></span>


        <h5 class="card-title"><?= $model->title ?> </h5>
        <p class="card-text"><?= $model->description ?></p>


        <?= Html::a('View Course', ['course/view', 'id'=> $model->id, 'user_id'=> $model->user_id, 'category_id'=> $model->category_id, 'file_id'=> $model->file_id], ['class'=> 'btn btn-primary']) ?>


        <?php if($model->user_id == $userId){?>
        <?= Html::a('Update', ['course/update', 'id'=> $model->id, 'user_id'=> $model->user_id, 'category_id'=> $model->category_id, 'file_id'=> $model->file_id], ['class'=> 'btn btn-primary']) ?>
        <div class="float-end">

            <?= Html::a('<i class="bi bi-x"></i>', ['delete', 'id' => $model->id, 'user_id'=> $model->user_id, 'category_id'=> $model->category_id, 'file_id'=> $model->file_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <?php }else{?>
        <div class="float-end">

            <?= Html::a('<i class="bi ' . $iconClass . ' icon-large"></i>', ['course/addfavourite', 'id' => $model->id], ['class' => $buttonClass, 'style' => 'outline: none;color: #FFD700;']) ?>


        </div>
        <?php }?>

    </div>
</div>


