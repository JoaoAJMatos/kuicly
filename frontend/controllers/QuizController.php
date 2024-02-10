<?php

namespace frontend\controllers;

use common\models\Course;
use common\models\Quiz;
use app\models\QuizSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * QuizController implements the CRUD actions for Quiz model.
 */
class QuizController extends Controller
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
     * Lists all Quiz models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new QuizSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Quiz model.
     * @param int $id ID
     * @param int $course_id Course ID
     * @param int $course_user_id Course User ID
     * @param int $course_category_id Course Category ID
     * @param int $course_file_id Course File ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $course_id, $course_user_id, $course_category_id, $course_file_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $course_id, $course_user_id, $course_category_id, $course_file_id),
        ]);
    }

    /**
     * Creates a new Quiz model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($course_id)
    {
        $model = new Quiz();

        $modelCourse = Course::find()->where(['id' => $course_id])->one();
        $model->course_id = $course_id;
        $model->course_user_id = $modelCourse->user_id;
        $model->course_category_id = $modelCourse->category_id;
        $model->course_file_id = $modelCourse->file_id;

        $model->time_limit = 0;
        $model->number_questions = 1;
        $model->max_points = 0;



        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['question/create', 'id' => $model->id, 'course_id' => $course_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Quiz model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $course_id Course ID
     * @param int $course_user_id Course User ID
     * @param int $course_category_id Course Category ID
     * @param int $course_file_id Course File ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $course_id, $course_user_id, $course_category_id, $course_file_id)
    {
        $model = $this->findModel($id, $course_id, $course_user_id, $course_category_id, $course_file_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'course_id' => $model->course_id, 'course_user_id' => $model->course_user_id, 'course_category_id' => $model->course_category_id, 'course_file_id' => $model->course_file_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Quiz model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $course_id Course ID
     * @param int $course_user_id Course User ID
     * @param int $course_category_id Course Category ID
     * @param int $course_file_id Course File ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $course_id, $course_user_id, $course_category_id, $course_file_id)
    {
        $this->findModel($id, $course_id, $course_user_id, $course_category_id, $course_file_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Quiz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $course_id Course ID
     * @param int $course_user_id Course User ID
     * @param int $course_category_id Course Category ID
     * @param int $course_file_id Course File ID
     * @return Quiz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $course_id, $course_user_id, $course_category_id, $course_file_id)
    {
        if (($model = Quiz::findOne(['id' => $id, 'course_id' => $course_id, 'course_user_id' => $course_user_id, 'course_category_id' => $course_category_id, 'course_file_id' => $course_file_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
