<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Lesson $model */
/** @var common\models\Section $modelSection */
/** @var common\models\Section $sectionList */
/** @var common\models\LessonType $lessonTypeList */
/** @var common\models\File $modelFile */
/** @var common\models\UploadForm $modelUpload */
/** @var common\models\Lesson $id */

$this->title = 'Update Lesson: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Lessons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id, 'sections_id' => $model->sections_id, 'quizzes_id' => $model->quizzes_id, 'file_id' => $model->file_id, 'lesson_type_id' => $model->lesson_type_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container py-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelSection' => $modelSection,
        'sectionList' => $sectionList,
        'lessonTypeList' => $lessonTypeList,
        'modelFile' => $modelFile,
        'modelUpload' => $modelUpload,
        'id' => $id,
    ]) ?>

</div>
