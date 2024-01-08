<?php

namespace backend\controllers;

use common\models\Question;
use app\models\QuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller
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
     * Lists all Question models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        if (Yii::$app->user->can('admin')){
        $searchModel = new QuestionSearch();


        $dataProvider = $searchModel->search(['QuestionSearch' => ['quizzes_id' => $id]]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        }else{
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Displays a single Question model.
     * @param int $id ID
     * @param int $quizzes_id Quizzes ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $quizzes_id)
    {
        if (Yii::$app->user->can('admin')){
        return $this->render('view', [
            'model' => $this->findModel($id, $quizzes_id),
        ]);
        }else{
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('restrito')){
        $model = new Question();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'quizzes_id' => $model->quizzes_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
        }else{
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $quizzes_id Quizzes ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $quizzes_id)
    {
        if (Yii::$app->user->can('restrito')){
        $model = $this->findModel($id, $quizzes_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'quizzes_id' => $model->quizzes_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
        }else{
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Deletes an existing Question model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $quizzes_id Quizzes ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $quizzes_id)
    {
        if (Yii::$app->user->can('admin')){
        $this->findModel($id, $quizzes_id)->delete();

        return $this->redirect(['index']);
        }else{
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $quizzes_id Quizzes ID
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $quizzes_id)
    {
        if (($model = Question::findOne(['id' => $id, 'quizzes_id' => $quizzes_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
