<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserForm $userForm */

/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($userForm, 'username')->textInput() ?>

    <?= $form->field($userForm, 'name')->textInput() ?>

    <?= $form->field($userForm, 'address')->textInput() ?>

    <?= $form->field($userForm, 'phone_number')->textInput() ?>

    <?= $form->field($userForm, 'email')->textInput() ?>

    <?= $form->field($userForm, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
