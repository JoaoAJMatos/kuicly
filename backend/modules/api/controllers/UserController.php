<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{

    public $modelClass = 'common\models\User';

    public $user = null;
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
             'class' => HttpBasicAuth::class,
             'auth' => [$this, 'auth'],
        ];
        return $behaviors;
    }

    public function auth($username, $password)
    {
        $user = User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            $this->user = $user;
            return $user;
        }
        throw new ForbiddenHttpException(('No Authentication'));
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if($this->user)
        {
            if($this->user->id == 1)
            {
                if($action==="delete")
                {
                    throw new ForbiddenHttpException('Proibido');
                }
            }
        }
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
}
