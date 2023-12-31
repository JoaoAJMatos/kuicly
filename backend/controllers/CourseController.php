<?php

namespace backend\controllers;

use common\models\Cart;
use common\models\CartItem;
use common\models\Course;
use app\models\CourseSearch;
use common\models\Lesson;
use common\models\Section;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
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
        if (Yii::$app->user->can('admin')){
            $searchModel = new CourseSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
            $model = new User();

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->redirect(['site/login']);
        }

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

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id, 'category_id' => $model->category_id, 'file_id' => $model->file_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'user_id' => $model->user_id, 'category_id' => $model->category_id, 'file_id' => $model->file_id]);
        }

        return $this->render('update', [
            'model' => $model,
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
        if (Yii::$app->user->can('admin')){

            // Encontre o carrinho do usuário
            $model = $this->findModel($id, $user_id, $category_id, $file_id);
            $modelCart = Cart::find()->where(['user_id' => $user_id])->one();

            if ($modelCart) {
                // Encontre o item do carrinho que corresponde ao curso
                $modelCartItem = CartItem::find()
                    ->where(['cart_id' => $modelCart->id, 'courses_id' => $id])
                    ->one();

                if ($modelCartItem) {
                    // Se o curso estiver no carrinho de alguém, exclua o item do carrinho
                    $modelCartItem->delete();
                }
            }
            $sections = Section::find()->where(['courses_id' => $model->id])->all();

            foreach ($sections as $section) {
                // Encontrar e excluir todas as seções associadas a cada lição
                $lessons = Lesson::find()->where(['sections_id' => $section->id])->all();
                foreach ($lessons as $lesson) {
                    // Excluir todos os quizzes associados a cada seção
                    //Quiz::deleteAll(['section_id' => $section->id]);

                    $lesson->delete();
                }

                $section->delete();
            }

            $this->findModel($id, $user_id, $category_id, $file_id)->delete();

            return $this->redirect(['index']);
        }else{
            return $this->redirect(['site/login']);
        }

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
