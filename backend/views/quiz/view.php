<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Quiz $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="quiz-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!empty($model->questions)): ?>
            <?= Html::a(
                'Question',
                ['question/view', 'id' => $model->questions[0]->id, 'quizzes_id' => $model->id],
                ['class' => 'btn btn-primary']
            ) ?>
        <?php endif; ?>

           </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
        ],
    ]) ?>



</div>
