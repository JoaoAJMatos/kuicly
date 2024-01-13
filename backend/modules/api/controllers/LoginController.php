<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**

Default controller for the api module*/
class LoginController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function actionLogin()
    {
        $userModel = new $this->modelClass;
        $request = \Yii::$app->request;
        $username = $request->getBodyParam('username');
        $password = $request->getBodyParam('password');

        $user = $userModel->find()->where(['username' => $username])->one();
        $id = $user->id;

        if (!$user || !$user->validatePassword($password)) {
            throw new ForbiddenHttpException('No Authentication');
        }

        $key = $user->getAuthKey();

        return ['token' => $key, 'id' => $id];

    }

}