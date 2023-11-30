<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Course $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="py-5">
    <div class="container-fluid bg-primary py-5 mb-5" >
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="display-5 text-white"> <?= $model->title ?> </h1>
                    <p class="lead text-white"> <?= $model->description ?> </p>
                    <p class="lead text-white">Classificação: Alunos:</p>
                    <p class="lead text-white">Criado: </p>
                </div>
                <div class="col-md-4">
                    <img src="<?= \Yii::getAlias('@webroot').'/uploads/' .  $model->file->path ?>" class="img-fluid" alt="Responsive image">
                </div>
            </div>
        <!--<h1><?php /*= Html::encode($this->title) */?></h1>
        <p> <?php /*= $model->description */?> </p>
        <p>Classificação: Alunos:</p>
        <p>Criado: </p>-->
    </div>

</div>

<div class="container py-5">



    <!--<button type="button" class="btn btn-primary btn-lg"><span>Increver-se por <?php /*= $model->price*/?>€</button>-->

   <!-- <p>
        <?php /*= Html::a('Update', ['update', 'id' => $model->id, 'user_id' => $model->user_id, 'category_id' => $model->category_id, 'file_id' => $model->file_id], ['class' => 'btn btn-primary']) */?>
        <?php /*= Html::a('Delete', ['delete', 'id' => $model->id, 'user_id' => $model->user_id, 'category_id' => $model->category_id, 'file_id' => $model->file_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>

    --><?php /*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
            'price',
            'skill_level',
            'user_id',
            'category_id',
            'file_id',
        ],
    ]) */?>

</div>
