<?php

namespace frontend\controllers;

use common\models\Cart;
use app\models\CartSearch;
use common\models\CartItem;
use common\models\Enrollment;
use common\models\Iva;
use common\models\Order;
use common\models\OrderItem;
use common\models\Profile;
use common\models\Transaction;
use common\models\User;
use frontend\models\CardPayment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex($user_id)
    {
        if (Yii::$app->user->can('comprarCurso')){
            $model = Cart::find()->where(['user_id' => $user_id])->one();
            $modelCardPayment = new CardPayment();

            $total = 0;
            if($model === null){
                $model = new Cart();
                $model->user_id = $user_id;
                $model->save();
            }

            foreach ($model->cartItems as $cartItem){

                $total += $cartItem->courses->price;
            }

            if ($this->request->isPost) {
                if ($modelCardPayment->load($this->request->post()) && $modelCardPayment->pay()) {

                    return $this->redirect(['payment', 'total' => $total]);
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('index', [
                'model' => $model,
                'total' => $total,
                'modelCardPayment' => $modelCardPayment,
                //'ivatotal'=> $total * 0.23,
            ]);

        }else{
            return $this->redirect(['site/index']);
        }

    }

    public function actionAdditemcard($id)
    {
        if(Yii::$app->user->can('adicionarCursoCarrinho')){
            $model = Cart::find()->where(['user_id' => Yii::$app->user->id])->one();
            if($model === null){
                $model = new Cart();
                $model->user_id = Yii::$app->user->id;
                $model->save();
            }
            $cartItem = new CartItem();
            $cartItem->cart_id = $model->id;
            $cartItem->courses_id = $id;
            $cartItem->save();
            return $this->redirect(['index','user_id'=>Yii::$app->user->id]);
        }else{
            return $this->redirect(['site/index']);
        }

    }

    public function actionPayment($total){

        if(Yii::$app->user->can('comprarCurso')){
            $user_id = Yii::$app->user->id;
            $modelCart = Cart::find()->where(['user_id' => $user_id])->one();
            $modelOrder = new Order();
            $modelIva = Iva::find()->where(['id' => 1])->one();
            // iva

            if(empty($modelCart->cartItems)){

                Yii::$app->session->setFlash('error', 'Não existe nada no carrinho.');
                return $this->redirect(['cart/index','user_id'=>Yii::$app->user->id]);
            }else{
                $modelOrder->date = date('Y-m-d H:i:s');
                $modelOrder->status = 'PAID';
                $modelOrder->total_price = $total;
                $modelOrder->user_id = $user_id;
                $modelOrder->iva_id = $modelIva->id;
                $modelOrder->save();

            }


            //$modelGetOrder = Order::find()->where(['user_id' => $user_id])->one();


            foreach ($modelCart->cartItems as $cartItem){

                // Criando um novo OrderItem para cada CartItem
                $modelOrderItem = new OrderItem();
                $modelOrderItem->orders_id = $modelOrder->id;
                // Associando ao pedido criado
                $modelOrderItem->courses_id = $cartItem->courses_id;
                $modelOrderItem->price = $cartItem->courses->price;
                $modelOrderItem->iva_price = $cartItem->courses->price;
                //todo: mudar iva_price para float

                // Outros dados do OrderItem (preço, quantidade, etc.) podem ser definidos aqui
                $modelOrderItem->save();

                $modelEnrollment = new Enrollment();
                $modelEnrollment->enrollment_date = date('Y-m-d H:i:s');
                $modelEnrollment->user_id = $user_id;
                $modelEnrollment->courses_id = $cartItem->courses_id;
                $modelEnrollment->save();

                $cartItem->delete();
            }

            return $this->redirect(['order/view', 'id' => $modelOrder->id, 'user_id' => $user_id]);

        }else{
            return $this->redirect(['site/index']);
        }


    }


    /**
     * Displays a single Cart model.
     * @param int $id ID
     * @param int $user_id User ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Cart();


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $user_id User ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $user_id)
    {
        $model = $this->findModel($id, $user_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $user_id User ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $user_id)
    {
        $this->findModel($id, $user_id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDeletecartitem($id,$user_id)
    {
        if(Yii::$app->user->can('retirarCursoCarrinho')){

            $cartItem = CartItem::findOne($id);

            if (!$cartItem) {
                throw new NotFoundHttpException('CartItem not found.');
            }

            // Delete the cartItem
            $cartItem->delete();

            // Redireciona para onde for adequado após a exclusão
            return $this->redirect(['cart/index','user_id'=>$user_id]); // Altere 'index' para a página desejada
        }else{
            return $this->redirect(['site/index']);
        }

    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $user_id User ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $user_id)
    {
        if (($model = Cart::findOne(['id' => $id, 'user_id' => $user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
