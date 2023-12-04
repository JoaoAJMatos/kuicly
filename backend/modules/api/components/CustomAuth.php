<?php
namespace backend\modules\api\components;
use common\models\User;
use Yii;
use yii\filters\auth\AuthMethod;
use yii\web\ForbiddenHttpException;

class CustomAuth extends AuthMethod
{
    public function authenticate($user, $request, $response)
    {
        $authToken = $request->getQueryString();
        $token=explode('=', $authToken)[1];
        $user = User::findIdentityByAccessToken($token);
        if(!$user)
        {
            throw new ForbiddenHttpException('No authentication'); //403
        }
        Yii::$app->params['id']=$user->id;
        return $user;
    }
}