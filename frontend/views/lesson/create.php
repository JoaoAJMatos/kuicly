<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Lesson $model */
/** @var common\models\Section $modelSection */
/** @var common\models\Section $sectionList */
/** @var common\models\LessonType $lessonTypeList */
/** @var common\models\File $modelFile */
/** @var common\models\UploadForm $modelUpload */

$this->title = 'Create Lesson';
$this->params['breadcrumbs'][] = ['label' => 'Lessons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

    ]) ?>

</div>
