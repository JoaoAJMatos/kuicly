<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use \yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Course $model */
/** @var common\models\Course $modelSection */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\Course $totalRating */
/** @var common\models\Course $totalAlunos */


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$userId = Yii::$app->user->id;
$enrollment = \common\models\Enrollment::find()->where(['user_id' => $userId, 'courses_id' => $model->id])->exists();
\yii\web\YiiAsset::register($this);
?>

<div class="py-5">
    <div class="container-fluid bg-primary py-5 mb-5" >
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="display-5 text-white"> <?= $model->title ?> </h1>
                    <p class="lead text-white"> <?= $model->description ?> </p>
                    <p class="lead text-white">Classificação: <?php for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $totalRating) { ?>
                                <i class="fas fa-star"></i>
                            <?php } else {?>
                                <i class="far fa-star"></i>
                            <?php }
                        }?> Alunos:<?= $totalAlunos?></p>
                    <p class="lead text-white">Criado: <?= $model->user->username ?> </p>



                </div>
                <div class="col-md-6">
                    <img src="<?= Yii::$app->urlManager->createUrl('uploads/'.$model->file->name) ?>" class="view-img" alt="Responsive image">
                </div>
            </div>

    </div>

</div>

<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <h2 style="margin-right: 20px; margin-bottom: 0;">Conteúdo do Curso</h2>
                <?php if(Yii::$app->user->can('instrutor')){?>
                <?= Html::a('Add Lessons', ['lesson/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php }?>
            </div>
            <div class="accordion" id="accordionExample">
                <?php foreach ($model->sections as $section){?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= $section->id?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $section->id?>" aria-expanded="true" aria-controls="collapse<?= $section->id?>">
                            <?= $section->title ?>
                        </button>
                    </h2>
                    <div id="collapse<?= $section->id?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $section->id?>" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($section->lessons as $lesson){?>
                                    <!--<li class="list-group-item"><?php /*= $lesson->title */?> </li>-->
                                    <?= Html::a(''. $lesson->title,['lesson/view', 'id'=>$lesson->id,'sections_id'=>$lesson->sections_id,'quizzes_id'=>$lesson->quizzes_id,'file_id'=>$lesson->file_id,'lesson_type_id'=>$lesson->lesson_type_id],['class'=>'list-group-item']) ?>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>


        <div class="col-md-6 ">
            <?php  if(!$enrollment && Yii::$app->user->id != $model->user_id){ ?>
            <div class="card float-end" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Buy your Course Now!</h5>
                        <?= Html::a('Buy for ' .$model->price. '$',['course/additemcard', 'id' => $model->id], ['class' => 'btn btn-primary btn-lg btn-block' ]) ?>
                </div>
            </div>
            <?php } ?>
        </div>

    </div>

</div>
