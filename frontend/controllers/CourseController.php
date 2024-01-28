<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\CartItem;
use common\models\Course;
use common\models\Enrollment;
use common\models\Favorite;
use common\models\Lesson;
use common\models\Order;
use common\models\OrderItem;
use common\models\Rating;
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
        $totalRating = Rating::find()->where(['courses_id' => $id])->sum('rating');
        $totalAlunos = Enrollment::find()->where(['courses_id' => $id])->count();
        $totalRating = $totalRating / 5;
        return $this->render('view', [
            'model' => $this->findModel($id, $user_id, $category_id, $file_id),
            'totalRating' => $totalRating,
            'totalAlunos' => $totalAlunos,

        ]);
    }

    public function actionRating($id)
    {
        $userid = Yii::$app->user->id;
        $modelRating = new Rating();
        $userHasCourse = Enrollment::find()->where(['user_id' => $userid, 'courses_id' => $id]);

        if ($userHasCourse) {
            if ($modelRating->load(Yii::$app->request->post()) && $modelRating->validate()) {
                // Salve a avaliação para o curso específico
                $modelRating->user_id = $userid; // Supondo que o usuário esteja logado
                $modelRating->courses_id = $id; // Supondo que a avaliação esteja associada ao curso
                $modelRating->save();

                Yii::$app->session->setFlash('success', 'Avaliação enviada com sucesso.');
                return $this->refresh(); // Ou redirecione para qualquer página desejada após enviar a avaliação
            } else {
                Yii::$app->session->setFlash('error', 'Falha ao enviar a avaliação.');
            }
        } else {
            Yii::$app->session->setFlash('info', 'Para avaliar o curso tem de estar inscrito no mesmo.');
        }
        return $this->refresh();
    }

    /**
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('criarCurso')){

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

        }else{
            return $this->redirect(['index']);
        }

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
        if(Yii::$app->user->can('editarCurso')){
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
        }else{
            return $this->redirect(['index']);
        }

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
        if(Yii::$app->user->can('apagarCurso')){
            $this->findModel($id, $user_id, $category_id, $file_id)->delete();

            return $this->redirect(['mycourse']);
        }else{
            return $this->redirect(['index']);
        }

    }

    public function actionAdditemcard($id)
    {
        // Verifique se o usuário está autenticado
        if (Yii::$app->user->can('adicionarCursoCarrinho')) {
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
                return $this->redirect(['index']);
            } else {

                Yii::$app->session->setFlash('info', 'Este item já está no seu carrinho.');
                return $this->redirect(['index']);
                // Se o curso já está no carrinho, você pode lidar com isso aqui
                // Pode exibir uma mensagem ou redirecionar para algum lugar
            }
        } else {
            // Se o usuário não estiver autenticado, redirecione para a página de login
            return $this->redirect(['site/login']);
        }

    }

    public function actionMycourse(){

        if (Yii::$app->user->can('inscreverEmCurso')) {
            $searchModel = new CourseSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            $userId = Yii::$app->user->id;
            $dataProvider->query->andWhere(['user_id' => $userId]);

            $enrolledCourseIds = Enrollment::find()
                ->select('courses_id')
                ->where(['user_id' => $userId])
                ->column();

            if($enrolledCourseIds === null){
                $dataProvider2 = new \yii\data\ArrayDataProvider();
            }else{

                $dataProvider2 = $searchModel->search(array_merge($this->request->queryParams, ['courseIds' => $enrolledCourseIds]));
            }


            return $this->render('mycourse', [
                'dataProvider' => $dataProvider,
                'dataProvider2' => $dataProvider2,

            ]);
        }else{
            return $this->redirect(['index']);
        }


    }

    public function actionAddfavourite($id){

        if(Yii::$app->user->can('marcarCursoFavorito')){

            $userId = Yii::$app->user->id;

            // Verifica se o curso já está nos favoritos do usuário
            $favorite = Favorite::find()->where(['courses_id' => $id, 'user_id' => $userId])->one();

            if ($favorite) {
                // Se o curso estiver nos favoritos, remove
                $favorite->delete();
                Yii::$app->session->setFlash('success', 'Curso removido dos favoritos com sucesso.');
            } else {
                // Se o curso não estiver nos favoritos, adiciona
                $model = new Favorite();
                $model->user_id = $userId;
                $model->courses_id = $id;
                $model->save();

                Yii::$app->session->setFlash('success', 'Curso adicionado aos favoritos com sucesso.');
            }

            return $this->redirect(['index']);
        }else{
            return $this->redirect(['index']);
        }

    }

    public function actionIncome()
    {
        $instrutorId = Yii::$app->user->id;
        // Busca todos os cursos associados ao instrutor
        $cursosDoInstrutor = Course::find()
            ->where(['user_id' => $instrutorId])
            ->all();
        $eachprice=[];
        $totalVendas = 0;
        $quantidade = 0;
        foreach ($cursosDoInstrutor as $curso) {
            // Encontra todas as vendas (orders) relacionadas a cada curso do instrutor
            $vendasDoCurso = OrderItem::find()
                    ->where(['courses_id' => $curso->id])
                    ->all();

            $teste = 0;
            $quantidade = 0;
            // Calcula o total de vendas para cada curso
            foreach ($vendasDoCurso as $venda) {
                $quantidade++;
                $teste += $venda->price;
                $totalVendas += $venda->price; // Supondo que 'total' seja o valor total da venda
            }
            $eachprice[$curso->id] = $teste;
        }

        return $this->render('income', [
            'cursosDoInstrutor' => $cursosDoInstrutor,
            'totalVendas' => $totalVendas,
            'eachprice' => $eachprice,
            'quantidade' => $quantidade,

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
