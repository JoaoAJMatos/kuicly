<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserForm $user */
/** @var common\models\Profile $profile */


$this->title = 'Update User: ' . $user->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($user, 'username')->textInput() ?>

    <?= $form->field($profile, 'name')->textInput() ?>

    <?= $form->field($profile, 'address')->textInput() ?>

    <?= $form->field($profile, 'phone_number')->textInput() ?>

    <?= $form->field($user, 'email')->textInput() ?>

    <?php /*= $form->field($user, 'password')->passwordInput()*/?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!--<div class="user-create">

    <h1><?php /*= Html::encode($this->title) */?></h1>

    <?php /*= $this->render('_form', [
        'userForm' => $userForm,
    ]) */?>

</div>
-->
