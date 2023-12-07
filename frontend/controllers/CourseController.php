<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\CartItem;
use common\models\Course;
use common\models\Lesson;
use common\models\Section;
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
            if ($model->load($this->request->post()) && $modelFile->load($this->request->post()) ) {

                $modelFile->path = UploadedFile::getInstance($modelFile, 'path');

                if (function_exists('com_create_guid') === true) {
                    $modelFile->name = trim(com_create_guid(), '{}');
                }

                $modelFile->file_type_id = 2;
                //TODO: verificação do ficheiro

                //$model->category_id = $categoryList->id;
                $modelFile->save();
                $model->file_id = $modelFile->id;

                if ($model->save() && $modelFile->save() && $modelFile->upload()) {

                    return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id, 'category_id' => $model->category_id, 'file_id' => $model->file_id]);
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

        $modelFile = File::findOne(['id' => $model->file_id]); // Supondo que existe um relacionamento com o arquivo
        //buscar o $model->file->path

        $modelCategory = $model->category;


        $categories = Category::find()->all();
        $categoryList = [];

        foreach ($categories as $category) {
            $categoryList[$category->id] = $category->category_name;
        }
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $modelFile->path = UploadedFile::getInstance($modelFile, 'path');

            if ($modelFile->save() && $modelFile->upload()) {
                $model->file_id = $modelFile->id;
                $model->save(); // Atualiza o curso com o ID do arquivo relacionado
            }


            return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id, 'category_id' => $model->category_id, 'file_id' => $model->file_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelFile' => $modelFile,
            'categoryList' => $categoryList,
            'modelCategory' => $modelCategory,
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

                return $this->redirect(['course/view', 'id' => $id, 'user_id' => $modelCartItem->courses->user_id, 'category_id' => $modelCartItem->courses->category_id, 'file_id' => $modelCartItem->courses->file_id]);
            } else {
                // Se o curso já está no carrinho, você pode lidar com isso aqui
                // Pode exibir uma mensagem ou redirecionar para algum lugar
            }
        } else {
            // Se o usuário não estiver autenticado, redirecione para a página de login
            return $this->redirect(['site/login']);
        }
    }

    public function actionMycourse(){
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $userId = Yii::$app->user->id;

        $dataProvider->query->andWhere(['user_id' => $userId]);

        return $this->render('mycourse', [
            'dataProvider' => $dataProvider,

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
