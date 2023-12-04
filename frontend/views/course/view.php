<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Course $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="py-5">
    <div class="container-fluid bg-primary py-5 mb-5" >
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="display-5 text-white"> <?= $model->title ?> </h1>
                    <p class="lead text-white"> <?= $model->description ?> </p>
                    <p class="lead text-white">Classificação: Alunos:</p>
                    <p class="lead text-white">Criado: </p>
                </div>
                <div class="col-md-6">
                    <img src="<?= Yii::$app->urlManager->createUrl('uploads/'.$model->file->path) ?>" class="view-img" alt="Responsive image">
                </div>
            </div>
        <!--<h1><?php /*= Html::encode($this->title) */?></h1>
        <p> <?php /*= $model->description */?> </p>
        <p>Classificação: Alunos:</p>
        <p>Criado: </p>-->
    </div>

</div>

<div class="container py-5">



    <!--<button type="button" class="btn btn-primary btn-lg"><span>Increver-se por <?php /*= $model->price*/?>€</button>-->

   <!-- <p>
        <?php /*= Html::a('Update', ['update', 'id' => $model->id, 'user_id' => $model->user_id, 'category_id' => $model->category_id, 'file_id' => $model->file_id], ['class' => 'btn btn-primary']) */?>
        <?php /*= Html::a('Delete', ['delete', 'id' => $model->id, 'user_id' => $model->user_id, 'category_id' => $model->category_id, 'file_id' => $model->file_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>

    --><?php /*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
            'price',
            'skill_level',
            'user_id',
            'category_id',
            'file_id',
        ],
    ]) */?>

    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Accordion Item #1
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Accordion Item #2
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">An item</li>
                        <li class="list-group-item">A second item</li>
                        <li class="list-group-item">A third item</li>
                        <li class="list-group-item">A fourth item</li>
                        <li class="list-group-item">And a fifth one</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                    Accordion Item #3
                </button>
            </h2>
            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                <div class="accordion-body">
                    <div class="list-group">
                        <button type="button" class="list-group-item list-group-item-action active" aria-current="true">
                            The current button
                        </button>
                        <button type="button" class="list-group-item list-group-item-action">A second item</button>
                        <button type="button" class="list-group-item list-group-item-action">A third button item</button>
                        <button type="button" class="list-group-item list-group-item-action">A fourth button item</button>
                        <button type="button" class="list-group-item list-group-item-action" disabled>A disabled button item</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
