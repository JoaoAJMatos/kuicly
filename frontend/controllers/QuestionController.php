<?php

namespace frontend\controllers;

use common\models\Answer;
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
    public function actionIndex()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
        return $this->render('view', [
            'model' => $this->findModel($id, $quizzes_id),
        ]);
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id, $course_id)
    {
        $model = new Question();
        $model->quizzes_id = $id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['lesson/create', 'id' => $course_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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
        $model = $this->findModel($id, $quizzes_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'quizzes_id' => $model->quizzes_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAnswer($id, $sections_id, $quizzes_id, $file_id, $lesson_type_id)
    {
        $model = new Answer();
        $user_id = Yii::$app->user->id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $modelQuestion = Question::findOne(['id' => $model->questions_id]);

                if ($modelQuestion->correct_answer == $model->text) {
                    $model->is_correct = 1;

                } else {
                    $model->is_correct = 0;
                }

                $model->user_id = $user_id;
                $model->questions_quizzes_id = $quizzes_id;

                if ($model->save() && $model->validate()) {

                    if ($model->is_correct == 1) {
                        Yii::$app->session->setFlash('success', 'Rsposta certa');

                    }else{
                        Yii::$app->session->setFlash('error', 'Resposta errada');
                    }

                    return $this->redirect(['lesson/view', 'id' => $id, 'sections_id' => $sections_id, 'quizzes_id' => $quizzes_id, 'file_id' => $file_id, 'lesson_type_id' => $lesson_type_id]);

                }


            } else {
                $model->loadDefaultValues();
            }
        }


        return $this->render('answer', [
            'model' => $model,
        ]);


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
        $this->findModel($id, $quizzes_id)->delete();

        return $this->redirect(['index']);
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
