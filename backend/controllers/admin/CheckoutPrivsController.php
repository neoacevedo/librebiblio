<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace backend\controllers\admin;

use Yii;
use common\models\CheckoutPrivs;
use common\models\CheckoutPrivsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CheckoutPrivsController implements the CRUD actions for CheckoutPrivs model.
 */
class CheckoutPrivsController extends Controller 
{

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        //'actions' => ['users'],
                        'allow' => true,
                        'roles' => ['admin'],
                        /*'matchCallback' => function () {
                            $roles = (array) Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                            //Yii::info($roles);
                            if (array_key_exists("admin", $roles)) {
                                return true;
                            }

                            return false;
                        },*/
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    /**
     * Gestión de errores
     * @return mixed
     */
    public function actions() {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all CheckoutPrivs models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CheckoutPrivsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CheckoutPrivs model.
     * @param integer $id
     * @param integer $material_cd
     * @param integer $classification_id
     * @return mixed
     */
    public function actionView(int $id, int $material_cd, int $classification_id) {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('view', [
                    'model' => $this->findModel($id, $material_cd, $classification_id),
        ]);
    }

    /**
     * Creates a new CheckoutPrivs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new CheckoutPrivs();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'material_cd' => $model->material_cd, 'classification_id' => $model->classification_id]);
        } else {
            @array_walk_recursive($model->errors, function($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CheckoutPrivs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $material_cd
     * @param integer $classification_id
     * @return mixed
     */
    public function actionUpdate(int $id, int $material_cd, int $classification_id) {
        $model = $this->findModel($id, $material_cd, $classification_id);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'material_cd' => $model->material_cd, 'classification_id' => $model->classification_id]);
        } else {
            @array_walk_recursive($model->errors, function($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CheckoutPrivs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $material_cd
     * @param integer $classification_id
     * @return mixed
     */
    public function actionDelete(int $id, int $material_cd, int $classification_id) {
        $this->findModel($id, $material_cd, $classification_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CheckoutPrivs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $material_cd
     * @param integer $classification_id
     * @return CheckoutPrivs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id, int $material_cd, int $classification_id) {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if (($model = CheckoutPrivs::findOne(['id' => $id, 'material_cd' => $material_cd, 'classification_id' => $classification_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
