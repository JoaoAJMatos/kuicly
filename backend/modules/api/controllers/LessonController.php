<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Course;
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
class LessonController extends ActiveController
{

    public $modelClass = 'common\models\Lesson';

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

    public function actionLessonsbycourse($id)
    {
        $modelSection = Section::find()->where(['courses_id' => $id])->all();

        $lessonsBySection = [];

        // Iterar sobre cada seção e obter as lições associadas
        /*foreach ($modelSection as $section) {
            $lessons = $this->modelClass::find()->where(['sections_id' => $section->id])->all();
            $lessonsBySection[$section->id] = $lessons; // Agrupa lições por seção usando o nome da seção como chave
        }*/

        foreach ($modelSection as $section) {
            $lessons = $this->modelClass::find()
                ->select(['id','title', 'context', 'file_id']) // Exclude 'id' and 'sections_id'
                ->where(['sections_id' => $section->id, 'lesson_type_id' => 13])
                ->all();

            foreach ($lessons as $lesson) {
                $file = $lesson->file;
                $lesson->file_id =$file->name;

            }

            // Group lessons by section using the section ID as the key
            $lessonsBySection = array_merge($lessonsBySection, $lessons);
        }

        return $lessonsBySection;
    }

    public function actionLesson($id)
    {
        $lesson = $this->modelClass::findOne($id);

        if ($lesson){
            $file = $lesson->file;

            if ($file) {
                // Retornar os detalhes do arquivo
                return [
                    'id' => $lesson->id,+
                    'title' => $lesson->title,
                    'context' => $lesson->context,
                    'section_id' => $lesson->sections_id,
                    'video' => $file->name,
                    // Adicione outros atributos do arquivo conforme necessário
                ];
            } else {
                return ['error' => 'Curso não tem um arquivo associado.'];
            }



        }
        return $lesson;
    }



    public function actionLessonbytitle($title)
    {
        $lesson = $this->modelClass::find()->where(['title' => $title])->one();
        if ($lesson) {
            return $lesson;
        }
        return ['error' => 'Lesson not found.'];
    }

    public function actionDeletebytitle($title)
    {
        $lesson = $this->modelClass::find()->where(['title' => $title])->one();
        if ($lesson) {
            $lesson->delete();
            return ['message' => 'Lesson deleted.'];
        }
        return ['error' => 'Lesson not found.'];
    }

    public function actionUpdatecontextbytitle($title)
    {
        $request = \Yii::$app->request;
        $lesson = $this->modelClass::find()->where(['title' => $title])->one();
        $newContext = $request->getBodyParam('context');
        if ($lesson) {

            $lesson->context = $newContext;
            $lesson->save();
            return ['message' => 'Lesson updated.'];
        }
        return ['error' => 'Lesson not found.'];
    }

    public function actionCreate()
    {
        $lesson = new $this->modelClass;
        $request = \Yii::$app->request;
        $lesson->title = $request->getBodyParam('title');
        $lesson->context = $request->getBodyParam('context');
        $sections_id = $request->getBodyParam('sections_id');
        $file_id = $request->getBodyParam('file_id');
        $quizzes_id = $request->getBodyParam('quizzes_id');
        $lesson_type_id = $request->getBodyParam('lesson_type_id');

        if ($sections_id) {
            $lesson->sections_id = $sections_id;
        }
        if ($file_id) {
            $lesson->file_id = $file_id;
        }
        if ($quizzes_id) {
            $lesson->quizzes_id = $quizzes_id;
        }
        if ($lesson_type_id) {
            $lesson->lesson_type_id = $lesson_type_id;
        }

        if ($lesson->save()) {

            return ['message' => 'Lesson created.'];
        } else {
            return ['error' => $lesson->errors];
        }


    }

}