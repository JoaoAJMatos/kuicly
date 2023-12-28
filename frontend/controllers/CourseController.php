<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\CartItem;
use common\models\Course;
use common\models\Enrollment;
use common\models\Lesson;
use common\models\Section;
use common\models\UploadForm;
use common\models\User;
use common\models\Category;
use common\models\File;
use app\models\CourseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\UploadedFile;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller
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
     * Lists all Course models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Course model.
     * @param int $id ID
     * @param int $user_id User ID
     * @param int $category_id Category ID
     * @param int $file_id File ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $user_id, $category_id, $file_id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id, $user_id, $category_id, $file_id),

        ]);
    }

    /**
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $modelUpload = new UploadForm();
        $model = new Course();
        $modelUser = new User();
        $modelCategory = new Category();
        $modelFile = new File();
        $categories = Category::find()->all();
        $categoryList = [];
        foreach ($categories as $category) {
            $categoryList[$category->id] = $category->category_name;
            $model->category_id = $category->id;
        }

        $model->user_id = Yii::$app->user->id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {


                $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');

                if ($modelUpload->upload()){
                    $modelFile->name = $modelUpload->fileName;
                }


                $modelFile->file_type_id = 5;

                //TODO: verificação do ficheiro


                $modelFile->save();
                $model->file_id = $modelFile->id;
                if ($model->save()) {

                    return $this->redirect(['lesson/create', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
            $modelUser->loadDefaultValues();
            $modelCategory->loadDefaultValues();
            $modelFile->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'modelUser' => $modelUser,
            'modelCategory' => $modelCategory,
            'modelFile' => $modelFile,
            'categoryList' => $categoryList,
            'modelUpload' => $modelUpload,
        ]);
    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $user_id User ID
     * @param int $category_id Category ID
     * @param int $file_id File ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $user_id, $category_id, $file_id)
    {
        $model = $this->findModel($id, $user_id, $category_id, $file_id);
        $modelUpload = new UploadForm();
        $modelFile = File::find()->where(['id' => $model->file_id])->one();
        $modelCategory = $model->category;


        $categories = Category::find()->all();
        $categoryList = [];

        foreach ($categories as $category) {
            $categoryList[$category->id] = $category->category_name;
        }

        $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');
        if ($modelUpload->upload()) {
            $modelFile->name = $modelUpload->fileName;

        }
        $modelFile->save();
        $model->file_id = $modelFile->id;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id, 'category_id' => $model->category_id, 'file_id' => $model->file_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelFile' => $modelFile,
            'categoryList' => $categoryList,
            'modelCategory' => $modelCategory,
            'modelUpload' => $modelUpload,
        ]);
    }

    /**
     * Deletes an existing Course model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $user_id User ID
     * @param int $category_id Category ID
     * @param int $file_id File ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $user_id, $category_id, $file_id)
    {
        $this->findModel($id, $user_id, $category_id, $file_id)->delete();

        return $this->redirect(['mycourse']);
    }

    public function actionAdditemcard($id)
    {
        $previousUrl = Yii::$app->request->referrer;
        // Verifique se o usuário está autenticado
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;

            // Verifique se o carrinho já está criado
            $modelCart = Cart::findOne(['user_id' => $userId]);
            if($modelCart===null){
                $modelCart = new Cart();
                $modelCart->user_id = $userId;
                $modelCart->num_courses = 0;
                $modelCart->save();
            }else{
                $modelCart->num_courses++;
                $modelCart->save();
            }

            $modelCartItem = CartItem::findOne(['courses_id' => $id, 'cart_id' => $modelCart->id]);

            if ($modelCartItem === null) {
                $modelCartItem = new CartItem();
                $modelCartItem->courses_id = $id;
                $modelCartItem->cart_id = $modelCart->id;
                $modelCart->num_courses++;
                $modelCart->save();
                $modelCartItem->save();

                /*return $this->redirect(['course/view', 'id' => $id, 'user_id' => $modelCartItem->courses->user_id, 'category_id' => $modelCartItem->courses->category_id, 'file_id' => $modelCartItem->courses->file_id]);*/
                return $this->redirect([$previousUrl]);
            } else {

                // Se o item já está no carrinho
                Yii::$app->session->setFlash('info', 'Este item já está no seu carrinho.');
                return $this->redirect([$previousUrl]);
            }
        } else {
            // Se o usuário não estiver autenticado, redirecione para a página de login
            return $this->redirect(['site/login']);
        }
    }

    public function actionMycourse(){
        $searchModel = new CourseSearch();
        $modelEnrolment = new Enrollment();
        $dataProvider = $searchModel->search($this->request->queryParams);


        $userId = Yii::$app->user->id;
        $enrolledCourseIds = Enrollment::find()
            ->select('courses_id')
            ->where(['user_id' => $userId])
            ->column();
        if($enrolledCourseIds === null){
            $dataProvider2 = $searchModel->search(array_merge($this->request->queryParams, ['courseIds' => $enrolledCourseIds]));
        }else{
            $dataProvider2 = new \yii\data\ArrayDataProvider();
        }

        $dataProvider->query->andWhere(['user_id' => $userId]);



        return $this->render('mycourse', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,

        ]);
    }
    /**
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $user_id User ID
     * @param int $category_id Category ID
     * @param int $file_id File ID
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $user_id, $category_id, $file_id)
    {
        if (($model = Course::findOne(['id' => $id, 'user_id' => $user_id, 'category_id' => $category_id, 'file_id' => $file_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
