<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Cart $model */

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
                <h3 class="text-center">Datos del cliente</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center">Nombre: <?= $model->profile->name ?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center">Dirección: <?= $model->profile->address ?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center">Teléfono: <?= $model->profile->phone_number ?></h5>
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
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model->cartItems as $cartItem): ?>
                            <tr>
                                <td><?= $cartItem->courses->name ?></td>
                                <td><?= $cartItem->courses->price ?>€</td>
                                <td><?= $cartItem->quantity ?></td>
                                <td><?= $cartItem->courses->price * $cartItem->quantity ?>€</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>
