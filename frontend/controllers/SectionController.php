<?php

namespace frontend\controllers;

use common\models\Course;
use common\models\Section;
use app\models\SectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * SectionController implements the CRUD actions for Section model.
 */
class SectionController extends Controller
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
     * Lists all Section models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SectionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Section model.
     * @param int $id ID
     * @param int $courses_id Courses ID
     * @param int $user_id User ID
     * @param int $category_id Category ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $courses_id, $user_id, $category_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $courses_id, $user_id, $category_id),
        ]);
    }

    /**
     * Creates a new Section model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        if (Yii::$app->user->can('criarVideo')){
            $model = new Section();
            $modelCourse = Course::find()->where(['id' => $id])->one();
            $model->user_id = Yii::$app->user->id;
            $model->courses_id = $id;
            $model->category_id = $modelCourse->category_id;

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->redirect(['lesson/create', 'id' => $id]);
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
     * Updates an existing Section model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $courses_id Courses ID
     * @param int $user_id User ID
     * @param int $category_id Category ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $courses_id, $user_id, $category_id)
    {
        $model = $this->findModel($id, $courses_id, $user_id, $category_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'courses_id' => $model->courses_id, 'user_id' => $model->user_id, 'category_id' => $model->category_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Section model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $courses_id Courses ID
     * @param int $user_id User ID
     * @param int $category_id Category ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $courses_id, $user_id, $category_id)
    {
        $this->findModel($id, $courses_id, $user_id, $category_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Section model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $courses_id Courses ID
     * @param int $user_id User ID
     * @param int $category_id Category ID
     * @return Section the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $courses_id, $user_id, $category_id)
    {
        if (($model = Section::findOne(['id' => $id, 'courses_id' => $courses_id, 'user_id' => $user_id, 'category_id' => $category_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
