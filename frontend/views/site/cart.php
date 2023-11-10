<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ContactForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Cart';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class=" container-fluid my-5 ">
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
                                        <button type="button" name="" id="" class="btn  btn-primary ">PURCHASE $37 EUR</button>
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
                                <div class="row  justify-content-between">
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row">
                                            <img class=" img-fluid" src="https://i.imgur.com/6oHix28.jpg" width="62" height="62">
                                            <div class="media-body  my-auto">
                                                <div class="row ">
                                                    <div class="col-auto"><p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">1 Week Subscription</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" pl-0 flex-sm-col col-auto  my-auto"> <p class="boxed-1">2</p></div>
                                    <div class=" pl-0 flex-sm-col col-auto  my-auto "><p><b>179 EUR</b></p></div>
                                </div>
                                <hr class="my-2">
                                <div class="row  justify-content-between">
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row">
                                            <img class=" img-fluid " src="https://i.imgur.com/9MHvALb.jpg" width="62" height="62">
                                            <div class="media-body  my-auto">
                                                <div class="row ">
                                                    <div class="col"><p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">2 Week Subscription</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pl-0 flex-sm-col col-auto  my-auto"> <i class="bi bi-trash3"></i> </div>
                                    <div class="pl-0 flex-sm-col col-auto my-auto"><p><b>179 EUR</b></p></div>
                                </div>
                                <hr class="my-2">
                                <div class="row  justify-content-between">
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row">
                                            <img class=" img-fluid " src="https://i.imgur.com/6oHix28.jpg" width="62" height="62">
                                            <div class="media-body  my-auto">
                                                <div class="row ">
                                                    <div class="col"><p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">2 Week Subscription</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pl-0 flex-sm-col col-auto  my-auto"> <p class="boxed-1">2</p></div>
                                    <div class="pl-0 flex-sm-col col-auto my-auto"><p><b>179 SEK</b></p></div>
                                </div>
                                <hr class="my-2">
                                <div class="row ">
                                    <div class="col">
                                        <div class="row justify-content-between">
                                            <div class="col-4"><p class="mb-1"><b>Subtotal</b></p></div>
                                            <div class="flex-sm-col col-auto"><p class="mb-1"><b>179 EUR</b></p></div>
                                        </div>
                                        <div class="row justify-content-between">
                                            <div class="col"><p class="mb-1"><b>Shipping</b></p></div>
                                            <div class="flex-sm-col col-auto"><p class="mb-1"><b>0 EUR</b></p></div>
                                        </div>
                                        <div class="row justify-content-between">
                                            <div class="col-4"><p ><b>Total</b></p></div>
                                            <div class="flex-sm-col col-auto"><p  class="mb-1"><b>537 EUR</b></p> </div>
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