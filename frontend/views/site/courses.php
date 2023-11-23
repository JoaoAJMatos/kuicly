<?php

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\widgets\ActiveForm $model */

use yii\helpers\Html;

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-xxl py-5">
    <div class="btn-group">
    <!-- Example single danger button -->
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Category
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="#">Music</a></li>
            <li><a class="dropdown-item" href="#">Marketing</a></li>
            <li><a class="dropdown-item" href="#">Business</a></li>
        </ul>
        </div>
    </div>

    <div class="btn-group">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Dificulty
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">1</a></li>
                <li><a class="dropdown-item" href="#">2</a></li>
                <li><a class="dropdown-item" href="#">3</a></li>
            </ul>
        </div>
    </div>
    
    <br>
    <br>

    <div class="row row-cols-1 row-cols-md-4 g-4">
        <div class="col">
            <div class="card">
                <img src="img/topgbacano" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Melhor Curso</h5>

                    <p class="card-text">Torna-te um Top G.</p>
                    <?= Html::a('Ver Curso', ['site/courseDetail'], ['class'=> 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="img/topgbacano" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Melhor Curso</h5>
                    <p class="card-text">Torna-te um Top G.</p>
                    <?= Html::a('Ver Curso', ['site/courseDetail'], ['class'=> 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="img/topgbacano" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Melhor Curso</h5>
                    <p class="card-text">Torna-te um Top G.</p>
                    <?= Html::a('Ver Curso', ['site/courseDetail'], ['class'=> 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="img/topgbacano" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Melhor Curso</h5>
                    <p class="card-text">Torna-te um Top G.</p>
                    <?= Html::a('Ver Curso', ['site/courseDetail'], ['class'=> 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>


