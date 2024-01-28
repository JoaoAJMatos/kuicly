<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */
/** @var common\models\Lesson $model */
/** @var common\models\Lesson $modelCourse */
/** @var common\models\Lesson $modelAnswer */



$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Lessons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$userId = Yii::$app->user->id;
?>
<div class="container py-5">

    <div class="row">
        <div class="col-md-8">
            <?php if($model->lessonType->type === 'video'){ ?>
            <video id='myVideo' width="640" height="360" controls autoplay src="<?= Yii::$app->urlManager->createUrl('uploads/'.$model->file->name) ?>" style="border: 1px solid black"></video>

            <h1><?= Html::encode($this->title) ?></h1>

            <p> <?= $model->context ?> </p>


            <?php }else{ ?>
                <h1><?= Html::encode($this->title) ?></h1>
                <p> <?= $model->context ?> </p>

                <h1><?= $model->quizzes->title.'-'.$model->quizzes->number_questions ?> </h1>

                <p><?= $model->quizzes->description ?></p>

                <?php foreach ($model->quizzes->questions as $question){?>
                    <h2><?= $question->text ?></h2>

                    <p>Option 1 : <?= $question->option_one ?></p>
                    <p>Option 2 : <?= $question->option_two ?></p>
                    <p>Option 3 : <?= $question->option_three ?></p>
                    <p>Option 4 : <?= $question->option_four ?></p>

                    <?php $form = ActiveForm::begin(['action' => ['question/answer', 'id'=>$model->id, 'sections_id' => $model->sections_id, 'quizzes_id' => $model->quizzes_id, 'file_id' => $model->file_id, 'lesson_type_id' => $model->lesson_type_id]]); ?>
                    <?= $form->field($modelAnswer, 'questions_id')->hiddenInput(['value' => $question->id])->label(false) ?>
                    <?= $form->field($modelAnswer, 'text')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>


                <?php }?>

            <?php } ?>

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
                                        <?= Html::a(''. $lesson->title. '-'.$lesson->lessonType->type,['lesson/view', 'id'=>$lesson->id,'sections_id'=>$lesson->sections_id,'quizzes_id'=>$lesson->quizzes_id,'file_id'=>$lesson->file_id,'lesson_type_id'=>$lesson->lesson_type_id],['class'=>'list-group-item']) ?>
                                    <?php }?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
        </div>
            <div class="">
                <?php if ($modelCourse->user_id === $userId){?>
                <?= Html::a('editar lesson',['lesson/update','id'=>$model->id,'sections_id'=>$model->sections_id,'quizzes_id'=>$model->quizzes_id,'file_id'=>$model->file_id,'lesson_type_id'=>$model->lesson_type_id,'course_id'=>$modelCourse->id],['class'=>'btn btn-primary'])?>
                <?php }?>
            </div>

    </div>


</div>
    <script>
        // Aqui você recuperaria as notas do banco de dados ou de onde estão armazenadas
        // Por simplicidade, vamos criar uma estrutura fixa de notas para este exemplo
        const videoNotas = {
            '10': 'Nota no segundo 10',
            '30': 'Outra nota no segundo 30',
            // ...
        };

        const video = document.getElementById('myVideo');
        video.addEventListener('timeupdate', function() {
            const currentTime = Math.floor(video.currentTime); // Obtém o tempo atual do vídeo

            const nota = videoNotas[currentTime];
            if (nota) {
                // Exibe a nota de alguma forma na interface do usuário
                // Por exemplo, mostrando em uma caixa de diálogo, console, ou manipulando elementos HTML
                console.log('Nota:', nota);
            }
        });
    </script>