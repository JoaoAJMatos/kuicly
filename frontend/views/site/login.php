<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container py-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="my-1 mx-0" style="color:#999;">

                    Don't have an account? <?= Html::a('Register Now', ['site/signup']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <!--<form>
        <div class="col-sm-4">
            <label for="exampleInputtext1" class="form-label">Username</label>
            <input type="text" class="form-control" id="exampleInputtext1" >

        </div>
        <div class="col-sm-4">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <div class="my-1 mx-0" style="color:#999;">
            If you forgot your password you can
            <?php /*= Html::a('reset it', ['site/request-password-reset'], ['']) */?>
            <br>
            Need new verification email?
            <?php /*= Html::a('Resend', ['site/resend-verification-email'], ['']) */?>

        </div>
        <button type="submit" class="btn btn-primary d-none d-lg-block ">Submit</button>
    </form>-->
</div>
