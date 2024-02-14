<?php

use common\models\Course;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var app\models\CourseSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\data\ActiveDataProvider $dataProvider2 */
/** @var app\common\Course $model */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container py-5">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(Yii::$app->user->can('instrutor')){?>
        <p>
            <?= Html::a('Create Course', ['create'], ['class' => 'btn btn-primary']) ?>
        </p>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_listmycourse',
            'options' => [
                'class' => 'row row-cols-1 row-cols-md-3 g-3',
            ],
            'itemOptions' => [
                'class' => 'col',
            ],
            'summary'=>'',
        ]);
        ?>

        <hr>
        <h1>Courses Buyed</h1>
    <?php }?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider2,
        'itemView' => '_listmycourse',
        'options' => [
            'class' => 'row row-cols-1 row-cols-md-3 g-3',
        ],
        'itemOptions' => [
            'class' => 'col',
        ],
        'summary'=>'',
    ]);
    ?>


</div>