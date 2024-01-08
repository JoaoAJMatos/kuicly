<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Cart $model */
/** @var common\models\Cart $modelOrder */
/** @var common\models\Cart $modelOrderItem */
/** @var common\models\Cart $modelProfile */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container py-5">


    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Factura</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">Dados do cliente</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-center">Nome: <?= $modelProfile->name ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-center">Adress: <?= $modelProfile->address ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-center">Telefone: <?= $modelProfile->phone_number ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-center">Email: <?= $model->email ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">Datos de la compra</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="text-center">Fecha: <?= $model->created_at ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">Productos</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>iva Price</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($modelOrderItem as $orderItem): ?>
                    <tr>
                        <td><?= $orderItem->courses->title ?></td>
                        <td><?= $orderItem->price ?>€</td>
                        <td><?= $orderItem->iva_price ?>€</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <h3 class="text-center">Total: <?= $modelOrder->total_price ?>€</h3>
        </div>
    </div>


</div>
