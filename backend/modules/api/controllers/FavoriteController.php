<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Course;
use common\models\Favorite;
use common\models\Section;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `api` module
 */
class FavoriteController extends ActiveController
{

    public $modelClass = 'common\models\Favorite';

    public $user = null;
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            //'auth' => [$this, 'authCustom'],
        ];
        return $behaviors;
    }

    /*public function auth($username, $password)
    {
        $user = User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            $this->user = $user;
            return $user;
        }
        throw new ForbiddenHttpException(('No Authentication'));
    }*/
    public function authCustom($token)
    {
        $user_ = User::findIdentityByAccessToken($token);
        if($user_) {
            $this->user=$user_; //Guardar user autenticado
            return $user_;
        }
        throw new \yii\web\ForbiddenHttpException('No authentication'); //403
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

    public function actionAdd($course_id, $id)
    {
        // Verifica se o curso já está nos favoritos do usuário
        $model = $this->modelClass::find()->where(['courses_id' => $course_id, 'user_id' => $id])->one();

        if ($model) {
            // Se o curso estiver nos favoritos, remove
            $model->delete();
            return false;

        } else {
            // Se o curso não estiver nos favoritos, adiciona
            $model = new Favorite();
            $model->user_id = $id;
            $model->courses_id = $course_id;
            $model->save();

            return true;

        }

    }

    public function actionHasfavorite($course_id, $id){
        $model = $this->modelClass::find()->where(['courses_id' => $course_id, 'user_id' => $id])->one();
        if($model){
            return true;
        }else{
            return false;
        }
    }




}