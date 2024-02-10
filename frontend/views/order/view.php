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
/** @var common\models\Order $subtotal*/

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container py-5">

    <div class="row">
        <div class="col-md-12">
            <h1 class="">Invoice</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                <h3 class="">Customer Information</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="">Name: <?= $modelProfile->name ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="">Address: <?= $modelProfile->address ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="">Phone Number: <?= $modelProfile->phone_number ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 class="">Email: <?= $modelUser->email ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="">Products</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Iva Price</th>
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
                <h3 class="">SubTotal: <?= $subtotal ?>€</h3>
            <h3 class="">Total IVA: <?= $totaliva ?>€</h3>
            <h3 class="">Total: <?= $model->total_price ?>€</h3>
        </div>
    </div>
</div>
