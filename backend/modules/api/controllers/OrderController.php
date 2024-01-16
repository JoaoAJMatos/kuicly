<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Course;
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
class OrderController extends ActiveController
{

    public $modelClass = 'common\models\Order';

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

    public function actionItems($id)
    {
        $order = $this->modelClass::findOne($id);

        if ($order === null) {
            // Handle the case where the cart is not found
            return ['error' => 'order not found'];
        }
        if ($order->orderItems === null) {
            // Handle the case where the cart is not found
            return ['error' => 'order item not found'];
        }

        $fullOrder = [];

        foreach ($order->orderItems as $item) {
            $course = \common\models\Course::find()->where(['id' => $item->courses_id])->one();

            $fullOrder[] = [
                'id' => $item->id,
                'price' => $item->price,
                'iva_price'=> $item->iva_price,
                'course_id'=> $item->courses_id,
                'order_id'=> $item->orders_id,
                'course_title'=> $course->title,

                // Add other order item attributes as needed
            ];
        }

        return $fullOrder;

    }

    public function actionAllorders()
    {
        $orders = $this->modelClass::find()->all();
        foreach ($orders as $order) {
            $user = $order->user;
            $order->user_id = $user->username;
        }
        return $orders;

    }

    public function actionOrder($id)
    {
        $order = $this->modelClass::findOne($id);
        $iva = $order->iva;


        $total = $order->total_price;
        $totaliva = $total * ($iva->iva / 100);
        $subtotal = $total - $totaliva;

        $fullOrder= [
            'id' => $order->id,
            'user_id' => $order->user_id,
            'total_price' => $order->total_price,
            'date' => $order->date,
            'iva' => $iva->iva,
            'totaliva' => $totaliva,
            'subtotal' => $subtotal,

        ];

        return $fullOrder;
    }



}