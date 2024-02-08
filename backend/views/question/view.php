<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Question $model */

$this->title = $model->text;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
         <?= Html::a('Delete', ['delete', 'id' => $model->id, 'quizzes_id' => $model->quizzes_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'text',
            'option_one',
            'option_two',
            'option_three',
            'option_four',
            'correct_answer',
        ],
    ]) ?>

</div>
