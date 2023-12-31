<?php

use common\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\CartSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\CartSearch $model */
/** @var app\models\Order $modelOrder */
/** @var app\models\Cart $total */

$this->title = 'Carts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="py-5">


    <div class="row justify-content-center ">
        <div class="col-xl-10">
            <div class="row justify-content-around">
                <div class="col-md-5">
                    <div class="card border-0">
                        <div class="card-header service-item ">
                            <h2 class="card-title space ">Checkout</h2>
                            <p class="card-text text-muted mt-4  space">SHIPPING DETAILS</p>
                            <hr class="my-0">
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-auto mt-0"><p><b>BBBootstrap Team Vasant Vihar  110020 New Delhi India</b></p></div>
                                <div class="col-auto"><p><b>BBBootstrap@gmail.com</b> </p></div>
                            </div>
                            <div class="row mt-4">
                                <div class="col"><p class="text-muted mb-2">PAYMENT DETAILS</p><hr class="mt-0"></div>
                            </div>
                            <div class="form-group">
                                <label for="NAME" class="small text-muted mb-1">NAME ON CARD</label>
                                <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="BBBootstrap Team">
                            </div>
                            <div class="form-group">
                                <label for="NAME" class="small text-muted mb-1">CARD NUMBER</label>
                                <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="4534 5555 5555 5555">
                            </div>
                            <div class="row no-gutters">
                                <div class="col-sm-6 pr-sm-2">
                                    <div class="form-group">
                                        <label for="NAME" class="small text-muted mb-1">VALID THROUGH</label>
                                        <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="06/21">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="NAME" class="small text-muted mb-1">CVC CODE</label>
                                        <input type="text" class="form-control form-control-sm" name="NAME" id="NAME" aria-describedby="helpId" placeholder="183">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-md-5">
                                <div class="col">
                                    <br>

                                    <?= Html::a('PURCHASE'. $total.' EUR',['cart/payment','total'=>$total],['class'=> 'btn btn-primary'])?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-0 ">
                        <div class="card-header card-2 service-item ">
                            <p class="card-text text-muted mt-md-4  mb-2 space">YOUR ORDER <span class=" small text-muted ml-2 cursor-pointer">EDIT SHOPPING BAG</span> </p>
                            <hr class="my-2">
                        </div>
                        <div class="card-body pt-0">
                            <?php foreach ($model->cartItems as $cartitem ) { ?>
                                <div class="row  justify-content-between">
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row">
                                            <img class=" img-fluid " src="<?= Yii::$app->urlManager->createUrl('uploads/'. $cartitem->courses->file->name) ?>" width="62" height="62">
                                            <div class="media-body  my-auto">
                                                <div class="row ">
                                                    <div class="col"><p class="mb-0"><b><?= $cartitem->courses->title ?></b></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pl-0 flex-sm-col col-auto  my-auto"> <p class="boxed-1">1</p></div>
                                    <div class="pl-0 flex-sm-col col-auto my-auto"><p><b><?= $cartitem->courses->price ?> EUR</b></p></div>
                                    <div class="float-end">

                                        <?= Html::a('<i class="bi bi-x"></i>', ['deletecartitem', 'id' => $cartitem->id,'user_id'=>$model->user_id], [
                                            'class' => 'btn btn-danger',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </div>
                                </div>
                                <hr class="my-2">
                            <?php } ?>
                            <div class="row  justify-content-between">
                                <div class="col-auto col-md-7">
                                    <div class="media flex-column flex-sm-row">
                                        <br>

                                        <?= Html::a(Html::img('@web/img/mais.jpg',['class'=>'img-fluid','width'=>"62" ,'height'=>"62"]),['course/index'])?>

                                        <div class="media-body  my-auto">
                                            <div class="row ">
                                                <div class="col"><p class="mb-0"><b></b></p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pl-0 flex-sm-col col-auto  my-auto">New Product</div>
                                <div class="pl-0 flex-sm-col col-auto my-auto"><p><b></b></p></div>
                            </div>
                            <hr class="my-2">
                            <div class="row ">
                                <div class="col">
                                    <div class="row justify-content-between">
                                        <div class="col"><p class="mb-1"><b>IVA</b></p></div>
                                        <div class="flex-sm-col col-auto"><p class="mb-1"><b><?php /*= $ivatotal*/?></b></p></div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-4"><p ><b>Total</b></p></div>
                                        <div class="flex-sm-col col-auto"><p  class="mb-1"><b><?=  $total?> EUR</b></p> </div>
                                    </div><hr class="my-0">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
