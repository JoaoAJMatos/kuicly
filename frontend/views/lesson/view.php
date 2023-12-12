<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Lesson $model */
/** @var common\models\Lesson $modelCourse */


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Lessons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container py-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--<p>
        <?php /*= Html::a('Update', ['update', 'id' => $model->id, 'sections_id' => $model->sections_id, 'quizzes_id' => $model->quizzes_id, 'file_id' => $model->file_id, 'lesson_type_id' => $model->lesson_type_id], ['class' => 'btn btn-primary']) */?>
        <?php /*= Html::a('Delete', ['delete', 'id' => $model->id, 'sections_id' => $model->sections_id, 'quizzes_id' => $model->quizzes_id, 'file_id' => $model->file_id, 'lesson_type_id' => $model->lesson_type_id], [
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
            'type',
            'context',
            'sections_id',
            'quizzes_id',
            'file_id',
            'lesson_type_id',
        ],
    ]) */?>

    <div class="row">
        <div class="col-md-8">

            <video width="640" height="360" controls preload="metadata" style="border: 2px solid black;">
                <source src="" type="video/mp4">
                <!-- Adicione outras tags source para diferentes tipos de arquivos de vídeo, se disponíveis -->
                Seu navegador não suporta a reprodução deste vídeo.
            </video>
        </div>
        <div class="col-md-4 ">
            <h2>Conteúdo do Curso</h2>
            <div class="accordion" id="accordionExample">
                <?php foreach ($modelCourse->sections as $section){?>
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


</div>
