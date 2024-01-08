<?php

namespace frontend\controllers;

use common\models\Order;
use app\models\OrderSearch;
use common\models\OrderItem;
use common\models\Profile;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('historicoDeCompras')) {
            $searchModel = new OrderSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Displays a single Order model.
     * @param int $id ID
     * @param int $user_id User ID
     * @param int $iva_id Iva ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $user_id, $iva_id)
    {
        if(Yii::$app->user->can('verFatura')) {
            $model = $this->findModel($id, $user_id, $iva_id);
            $modelUser = User::find()->where(['id' => $user_id])->one();
            $modelProfile = Profile::find()->where(['user_id' => $user_id])->one();
            $modelOrderItem = OrderItem::find()->where(['orders_id' => $id])->all();
            $totaliva = 0;

            foreach ($modelOrderItem as $orderItem) {
                $totaliva += $orderItem->iva_price;
            }

            return $this->render('view', [
                'model' => $this->findModel($id, $user_id, $iva_id),
                'modelUser' => $modelUser,
                'modelProfile' => $modelProfile,
                'modelOrderItem' => $modelOrderItem,
                'totaliva' => $totaliva,
                'subtotal' => $model->total_price - $totaliva,
            ]);

        }else{
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('emitirFactura')){

            $model = new Order();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id, 'iva_id' => $model->iva_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);

        }else{
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $user_id User ID
     * @param int $iva_id Iva ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $user_id, $iva_id)
    {
        if (Yii::$app->user->can('editarFactura')){
        $model = $this->findModel($id, $user_id, $iva_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id, 'iva_id' => $model->iva_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
        }else{
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $user_id User ID
     * @param int $iva_id Iva ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $user_id, $iva_id)
    {
        if (Yii::$app->user->can('apagarFactura')){
        $this->findModel($id, $user_id, $iva_id)->delete();

        return $this->redirect(['index']);
        }else{
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $user_id User ID
     * @param int $iva_id Iva ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $user_id, $iva_id)
    {
        if (($model = Order::findOne(['id' => $id, 'user_id' => $user_id, 'iva_id' => $iva_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
