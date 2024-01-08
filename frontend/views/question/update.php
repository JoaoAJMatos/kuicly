<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Question $model */

$this->title = 'Update Question: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'quizzes_id' => $model->quizzes_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
