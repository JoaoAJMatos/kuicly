<?php
use common\models\Course;
use common\models\Lesson;
use common\models\OrderItem;
use common\models\User;
use yii\helpers\Html;

$this->title = 'Home';
$this->params['breadcrumbs'] = [['label' => $this->title]];
$createdCoursesCount = Course::find()->count();
$createdLessonsCount = Lesson::find()->count();
$sellsCount = OrderItem::find()->count();
$userCount = User::find()->count();
?>
<div class="container-fluid">


    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Users Registered',
                'number' => $userCount,
                'icon' => 'fas fa-user',
                'theme' => 'primary'
            ]) ?>
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Sells Made',
                'number' => $sellsCount ,
                'icon' => 'fas fa-shopping-cart',
                'theme' => 'gradient-warning'
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Courses Available',
                'number' => $createdCoursesCount,
                'theme' => 'success',
                'icon' => 'fa fa-book',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Lessons Available',
                'number' => $createdLessonsCount,
                'theme' => 'success',
                'icon' => 'fa fa-scroll',
            ]) ?>
        </div>
    </div>
</div>