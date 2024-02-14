<?php

namespace frontend\controllers;

use common\models\Answer;
use common\models\Enrollment;
use common\models\Lesson;
use common\models\File;
use common\models\LessonType;
use common\models\Quiz;
use common\models\Section;
use common\models\Course;
use app\models\LessonSearch;
use common\models\UploadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
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
        if(Yii::$app->user->can('restrito')){
            $searchModel = new LessonSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);

            // Filtre as lições pelo ID do curso desejado
            //$dataProvider->query->andFilterWhere(['course_id' => $id]);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->redirect(['index']);
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
    public function actionView($id, $sections_id,$lesson_type_id)
    {
        if(Yii::$app->user->can('verVideo')){
            $model = $this->findModel($id, $sections_id,$lesson_type_id);
            $modelSection = Section::find()->where(['id' => $sections_id])->one();
            $modelCourse = Course::find()->where(['id' => $modelSection->courses_id])->one();
            $userId = Yii::$app->user->id;
            $enrollment = Enrollment::find()->where(['user_id' => $userId, 'courses_id' => $modelCourse->id])->exists();
            $modelAnswer = new Answer();
            $modelAnswerSubmit = Answer::find()->where(['questions_quizzes_id' => $model->quiz_id, 'user_id' => $userId])->one();
            if ($enrollment || $modelCourse->user_id == $userId) {


                return $this->render('view', [
                    'model' => $this->findModel($id, $sections_id, $lesson_type_id),
                    'modelCourse'=>$modelCourse,
                    'modelAnswer'=>$modelAnswer,
                    'modelAnswerSubmit'=>$modelAnswerSubmit,
                ]);
            }
            else {
                Yii::$app->session->setFlash('info', 'You dont have the Course.');
                return $this->redirect(['course/view', 'id' => $modelCourse->id,'user_id'=>$modelCourse->user_id,'category_id'=>$modelCourse->category_id, 'file_id' => $modelCourse->file_id]);
            }



        }else{
            return $this->redirect(['site/index']);
        }

    }

    /**
     * Creates a new Lesson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($course_id)
    {
        if (Yii::$app->user->can('criarVideo')){
            $userId = Yii::$app->user->id;
            $model = new Lesson();
            $modelUpload = new UploadForm();
            $modelSection = Section::find()->where(['courses_id' => $course_id])->all();
            $modelLessonType = LessonType::find()->all();
            $modelQuiz = Quiz::find()->where(['course_id' => $course_id])->all();
            $modelFile = new File();
            $sectionList = [];
            $lessonTypeList = [];
            $quizList = [];




            foreach ($modelSection as $section) {
                $sectionList[$section->id] = $section->title;
                $model->sections_id = $section->id;
            }

            foreach ($modelLessonType as $type){
                $lessonTypeList[$type->id] = $type->type;

            }


            foreach ($modelQuiz as $quiz){
                $quizList[$quiz->id] = $quiz->title;
                $model->quiz_id = $quiz->id;

            }


            if ($this->request->isPost) {


                if ($model->load($this->request->post()) ) {

                    if ($model->lessonType->type == 'Video'){


                        $model->quiz_id = null;
                        $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');

                        if ($modelUpload->upload()){
                            $modelFile->name = $modelUpload->fileName;
                        }

                        $modelFile->save();
                        $model->file_id = $modelFile->id;

                    }else if ($model->lessonType->type == 'Quiz'){
                        $model->file_id = null;

                    }


                    if ($model->save()) {

                        return $this->redirect(['view', 'id' => $model->id, 'sections_id' => $model->sections_id, 'lesson_type_id' => $model->lesson_type_id]);
                    }

                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
                'modelSection' => $modelSection,
                'sectionList' => $sectionList,
                'lessonTypeList' => $lessonTypeList,
                'modelFile' => $modelFile,
                'modelUpload' => $modelUpload,
                'course_id' => $course_id,
                'quizList' => $quizList,


            ]);
        }else{
            return $this->redirect(['site/index']);
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
    public function actionUpdate($id, $sections_id, $lesson_type_id, $course_id)
    {
        if(Yii::$app->user->can('editarVideo')) {
            $model = $this->findModel($id, $sections_id, $lesson_type_id);
            $modelUpload = new UploadForm();
            $modelSection = Section::find()->where(['courses_id' => $course_id])->all();
            $modelLessonType = LessonType::find()->all();
            $modelFile = File::find()->where(['id' => $model->file_id])->one();
            $sectionList = [];
            $lessonTypeList = [];
            $course_id = $model->sections->courses_id;
            $modelQuiz = Quiz::find()->where(['course_id' => $course_id])->all();
            $quizList = [];


            foreach ($modelSection as $section) {
                $sectionList[$section->id] = $section->title;
            }

            foreach ($modelLessonType as $type) {
                $lessonTypeList[$type->id] = $type->type;
            }

            foreach ($modelQuiz as $quiz){
                $quizList[$quiz->id] = $quiz->title;
                $model->quiz_id = $quiz->id;

            }

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {

                    $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');

                    if ($modelUpload->upload()) {
                        $modelFile->name = $modelUpload->fileName;
                    }

                    $modelFile->save();
                    $model->file_id = $modelFile->id;
                    if ($model->save()) {

                        return $this->redirect(['view', 'id' => $model->id, 'sections_id' => $model->sections_id, 'lesson_type_id' => $model->lesson_type_id]);
                    }
                }
            }

            return $this->render('update', [
                'model' => $model,
                'modelSection' => $modelSection,
                'sectionList' => $sectionList,
                'lessonTypeList' => $lessonTypeList,
                'modelFile' => $modelFile,
                'modelUpload' => $modelUpload,
                'course_id' => $course_id,
                'quizList' => $quizList,
            ]);

        }else{
            return $this->redirect(['site/index']);
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
    public function actionDelete($id, $sections_id,$lesson_type_id)
    {
        $this->findModel($id, $sections_id, $lesson_type_id)->delete();

        return $this->redirect(['index']);
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
