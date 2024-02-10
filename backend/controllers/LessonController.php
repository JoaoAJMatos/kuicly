<?php

namespace backend\controllers;

use common\models\Course;
use common\models\Lesson;
use app\models\LessonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * LessonController implements the CRUD actions for Lesson model.
 */
class LessonController extends Controller
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
     * Lists all Lesson models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        if(Yii::$app->user->can('admin')){
            $searchModel = new LessonSearch();
            $model = Course::findOne($id);
            $sectionIds = $model->getSections()->select('id')->column();
            //$dataProvider = $searchModel->search(['courses_id' => $id]);
            $dataProvider = $searchModel->search($this->request->queryParams);

            // Filtre as lições pelo ID da section do curso desejado


            $dataProvider->query->andWhere(['in', 'sections_id', $sectionIds]);
            //$dataProvider->query->andWhere(['sections_id' => $sectionIds]);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->redirect(['site/login']);
        }

    }

    /**
     * Displays a single Lesson model.
     * @param int $id ID
     * @param int $sections_id Sections ID
     * @param int $quizzes_id Quizzes ID
     * @param int $file_id File ID
     * @param int $lesson_type_id Lesson Type ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $sections_id, $lesson_type_id)
    {
        if(Yii::$app->user->can('admin')){
            return $this->render('view', [
                'model' => $this->findModel($id, $sections_id, $lesson_type_id),
            ]);
        }else{
            return $this->redirect(['site/login']);
        }

    }

    /**
     * Creates a new Lesson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('restrito')){
            $model = new Lesson();

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id, 'sections_id' => $model->sections_id,  'lesson_type_id' => $model->lesson_type_id]);
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
     * Updates an existing Lesson model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $sections_id Sections ID
     * @param int $quizzes_id Quizzes ID
     * @param int $file_id File ID
     * @param int $lesson_type_id Lesson Type ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $sections_id,  $lesson_type_id)
    {
        if(Yii::$app->user->can('restrito')){
            $model = $this->findModel($id, $sections_id, $lesson_type_id);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'sections_id' => $model->sections_id, 'lesson_type_id' => $model->lesson_type_id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            return $this->redirect(['site/login']);
        }

    }

    /**
     * Deletes an existing Lesson model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $sections_id Sections ID
     * @param int $quizzes_id Quizzes ID
     * @param int $file_id File ID
     * @param int $lesson_type_id Lesson Type ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $sections_id, $lesson_type_id)
    {
        if(Yii::$app->user->can('apagarVideo') && Yii::$app->user->can('admin')){
            $model = $this->findModel($id, $sections_id,  $lesson_type_id);
            $this->findModel($id, $sections_id, $lesson_type_id)->delete();

            return $this->redirect(['index','id'=>$model->sections->courses_id]);
        }else{
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Finds the Lesson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $sections_id Sections ID
     * @param int $quizzes_id Quizzes ID
     * @param int $file_id File ID
     * @param int $lesson_type_id Lesson Type ID
     * @return Lesson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $sections_id, $lesson_type_id)
    {
        if (($model = Lesson::findOne(['id' => $id, 'sections_id' => $sections_id, 'lesson_type_id' => $lesson_type_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
