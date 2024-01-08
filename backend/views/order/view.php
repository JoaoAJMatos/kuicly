<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Order $model */
/** @var common\models\Order $modelOrderItem */
/** @var common\models\Order $modelOrder */
/** @var common\models\Order $modelProfile */
/** @var common\models\Order $modelUser */
/** @var common\models\Order $totaliva */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="">

    <div class="row">
        <div class="col-md-12">
            <h1 class="">Factura</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="">Dados do cliente</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="">Nome: <?= $modelProfile->name ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="">Adress: <?= $modelProfile->address ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="">Telefone: <?= $modelProfile->phone_number ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="">Email: <?= $modelUser->email ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="">Productos</h3>
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
            <h3 class="">SubTotal: <?= $totaliva ?>€</h3>
            <h3 class="">Total IVA: <?= $totaliva ?>€</h3>
            <h3 class="">Total: <?= $model->total_price ?>€</h3>
        </div>
    </div>
</div>