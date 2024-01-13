<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Course;
use common\models\Enrollment;
use common\models\OrderItem;
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
class CartController extends ActiveController
{

    public $modelClass = 'common\models\Cart';

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
        $cart = $this->modelClass::find()->where(['user_id' => $id])->one();

        if ($cart === null) {
            // Handle the case where the cart is not found
            return [];
        }

        $items = \common\models\CartItem::find()->where(['cart_id' => $cart->id])->all();

        if (empty($items)) {
            return [];
        }

        $courses = [];
        foreach ($items as $item) {
            $course = \common\models\Course::find()->where(['id' => $item->courses_id])->one();

            if ($course) {
                $courses[] = [
                    'id'=>$item->id,
                    'course_id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'price' => $course->price,
                    'skill_level' => $course->skill_level,
                    'carrinho_id' => $item->id,

                    // Add other course attributes as needed
                ];
            }
        }

        return $courses;
    }

    public function actionAdditem($id, $course_id)
    {
        $cart = $this->modelClass::find()->where(['user_id' => $id])->one();
        $item = new \common\models\CartItem();
        $item->cart_id = $cart->id;
        $item->courses_id = $course_id;
        $item->save();

        return $item;
    }

    public function actionRemoveitem($id, $course_id)
    {
        $cart = $this->modelClass::find()->where(['user_id' => $id])->one();
        $item = \common\models\CartItem::find()->where(['cart_id' => $cart->id, 'courses_id' => $course_id])->one();
        $item->delete();

        return $item;
    }

    public function actionCreatecart()
    {
        $cart = new $this->modelClass;
        $request = \Yii::$app->request;
        $user_id = $request->getBodyParam('user_id');
        $cart->user_id = $user_id;
        $cart->save();
        return $cart;
    }

    public function actionPayment($id)
    {
        $cart = $this->modelClass::find()->where(['user_id' => $id])->one();
        $order = new \common\models\Order();
        $modeliva = \common\models\Iva::find()->one();

        if (empty($cart->cartItems)) {
            return ['error' => 'The cart is empty'];
        }

        $order->date = date('Y-m-d H:i:s');
        $order->status = 'PAID';
        $order->total_price = 0;
        $order->user_id = $id;
        $order->iva_id = $modeliva->id;
        $order->save();

        foreach ($cart->cartItems as $item) {

            $orderItem = new OrderItem();
            $orderItem->orders_id = $order->id;
            $orderItem->courses_id = $item->courses_id;
            $orderItem->price = $item->courses->price;
            $orderItem->iva_price = $item->courses->price * ($modeliva->iva / 100);
            $orderItem->save();

            $modelEnrollment = new Enrollment();
            $modelEnrollment->enrollment_date = date('Y-m-d H:i:s');
            $modelEnrollment->user_id = $id;
            $modelEnrollment->courses_id = $item->courses_id;
            $modelEnrollment->save();

            $order->total_price += $orderItem->price;

            $order->save();
            $item->delete();


        }



        return $order;
    }




}