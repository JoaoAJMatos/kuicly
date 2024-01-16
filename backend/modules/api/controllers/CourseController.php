<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Enrollment;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

/**
 * Default controller for the `api` module
 */
class CourseController extends ActiveController
{

    public $modelClass = 'common\models\Course';

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

    public function auth($username, $password)
    {
        $user = User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            $this->user = $user;
            return $user;
        }
        throw new ForbiddenHttpException(('No Authentication'));
    }
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


    public function actionSearch($title)
    {
        $course = new $this->modelClass;
        $recs = $course::find()->where(['like', 'title', $title])->all();
        return $recs;

    }

    public function actionAllcourses()
    {
        $courses = $this->modelClass::find()->all();
        foreach ($courses as $course) {
            $file = $course->file;
            $course->file_id = $file->name;

        }
        return $courses;

    }

    public function actionCourse($id)
    {
        $course = $this->modelClass::findOne($id);
        if ($course) {
            // Acessar a relação 'file' definida no modelo Course
            $file = $course->file;


            if ($file) {
                // Retornar os detalhes do arquivo
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'price' => $course->price,
                    'skill_level' => $course->skill_level,
                    'img' =>  $file->name,
                    // Adicione outros atributos do arquivo conforme necessário
                ];
            } else {
                return ['error' => 'Curso não tem um arquivo associado.'];
            }
        } else {
            return ['error' => 'Curso não encontrado.'];
        }
    }




    public function actionCreatecourse()
    {
        $request = \Yii::$app->request;
        $course = new $this->modelClass();


        // Set basic attributes
        $course->title = $request->post('title');
        $course->description = $request->post('description');
        $course->price = $request->post('price');
        $course->skill_level = $request->post('skill_level');
        $user_id = $request->post('user_id');

        if ($user_id) {
            // Assign the category_id attribute in your Course model
            $course->user_id = $user_id;
        }

        $file_id = $request->post('file_id');

        if ($file_id) {
            // Assign the category_id attribute in your Course model
            $course->file_id = $file_id;
        }
       /* if ($modelUpload->upload()){
            $modelFile->name = $modelUpload->fileName;
        }
        $modelFile->save();
        $course ->file_id = $modelFile->id;*/

        // Handle category assignment (assuming 'category_id' is the name attribute in the form)
        $category_id = $request->post('category_id');
        if ($category_id) {
            // Assign the category_id attribute in your Course model
            $course->category_id = $category_id;
        }

        // Save the course
        if ($course->save()) {
            return $course;
        } else {
            // Handle validation or saving errors
            return ['error' => $course->errors];
        }
    }

    public function actionUpdatecoursepricebytitle($title)
    {
        $request = \Yii::$app->request;
        $newPrice = $request->post('price');
        $course = $this->modelClass::findOne(['title' => $title]);

        if ($course){
            $course->price = $newPrice;
            $course->save();
        }else{
            return ['error' => 'Curso não encontrado.'];
        }


        return $course;
    }

    public function actionDeletecoursebytitle($title)
    {
        $course = $this->modelClass::findOne(['title' => $title]);
        $course->delete();
        return $course;
    }

    public function actionEnrollment($id)
    {
        $enrollment = Enrollment::find()->where(['user_id' => $id])->all();
        $myCourses = [];
        foreach ($enrollment as $enroll) {
           $course = $this->modelClass::find()->where(['id' => $enroll->courses_id])->one();
           $file = $course->file;
              $myCourses[] = [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'price' => $course->price,
                'skill_level' => $course->skill_level,
                'img' => $file->name,
              ];

        }
        return $myCourses;

    }

}
