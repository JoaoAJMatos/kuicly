<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Quiz $model */

$this->title = 'Update Quiz: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id, 'course_id' => $model->course_id, 'course_user_id' => $model->course_user_id, 'course_category_id' => $model->course_category_id, 'course_file_id' => $model->course_file_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quiz-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
