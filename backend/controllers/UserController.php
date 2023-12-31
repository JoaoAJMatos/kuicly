<?php

namespace backend\controllers;

use common\models\Course;
use common\models\Section;
use common\models\User;
use common\models\Profile;
use common\models\Lesson;
use backend\models\UserForm;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('criarUtilizador')){
            $model = new UserForm();


            if ($model->load($this->request->post()) && $model->createFormUser()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }else{
            return $this->redirect(['site/login']);
        }

    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('editarUtilizador')){
            $user = User::findOne($id);

            if (!$user) {
                throw new NotFoundHttpException("The user was not found.");
            }

            $profile = Profile::findOne(['user_id' => $id]);

            if (!$profile) {
                throw new NotFoundHttpException("The user has no profile.");
            }

            if ($user->load($this->request->post()) && $profile->load($this->request->post())) {

                $isValid = $user->validate();
                $isValid = $profile->validate() && $isValid;

                if ($isValid) {
                    $user->save();
                    $profile->save();

                    return $this->redirect(['user/view', 'id' => $user->id]);
                }

            }


            return $this->render('update', [
                'user' => $user,
                'profile' => $profile,
            ]);
        }else{
            return $this->redirect(['site/login']);
        }



    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('banirUtilizador')){
            $user = User::findOne($id);
            $profile = Profile::findOne(['user_id' => $user->id]);
            $courses = Course::find()->where(['user_id' => $id])->all();

            foreach ($courses as $course) {
                $sections = Section::find()->where(['courses_id' => $course->id])->all();

                foreach ($sections as $section) {
                    // Encontrar e excluir todas as seções associadas a cada lição
                    $lessons = Lesson::find()->where(['sections_id' => $section->id])->all();
                    foreach ($lessons as $lesson) {
                        // Excluir todos os quizzes associados a cada seção
                        //Quiz::deleteAll(['section_id' => $section->id]);

                        // Excluir a seção
                        $lesson->delete();
                    }

                    // Excluir a lição
                    $section->delete();
                }

                // Excluir o curso
                $course->delete();
            }
            if ($profile !== null) {
                // Excluir o perfil associado a esse usuário
                $profile->delete();
            }
            $user->delete();

            return $this->redirect(['index']);
        }else{
            return $this->redirect(['site/login']);
        }

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
