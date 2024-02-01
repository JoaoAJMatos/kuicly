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
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3><?= $userCount ?></h3>
                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <?= Html::a('More info <i class="fas fa-arrow-circle-right"></i>', ['user/index' ], ['class'=> 'small-box-footer']) ?>
            </div>

            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $sellsCount ?></h3>
                    <p>Sells</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <?= Html::a('More info <i class="fas fa-arrow-circle-right"></i>', ['order/index'], ['class'=> 'small-box-footer']) ?>
            </div>

        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $createdCoursesCount ?></h3>
                    <p>Created Courses</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>

                <?= Html::a('More info <i class="fas fa-arrow-circle-right"></i>', ['course/index'], ['class'=> 'small-box-footer']) ?>
            </div>

        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $createdLessonsCount ?></h3>
                    <p>Created Lessons</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <?= Html::a('More info <i class="fas fa-arrow-circle-right"></i>', ['course/index' ], ['class'=> 'small-box-footer']) ?>
            </div>

        </div>

    </div>
</div>