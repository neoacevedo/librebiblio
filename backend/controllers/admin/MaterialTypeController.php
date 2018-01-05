<?php

namespace backend\controllers\admin;

use Yii;
use backend\models\MaterialType;
use backend\models\MaterialTypeSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MaterialTypeController implements the CRUD actions for MaterialType model.
 */
class MaterialTypeController extends Controller {

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
                        //'actions' => ['index'],
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
     * Lists all MaterialType models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MaterialTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaterialType model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MaterialType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new MaterialType();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post())) {
            $model->image_file = UploadedFile::getInstance($model, 'image_file');
            if ($model->save() && $model->upload()) {
                // file is uploaded successfully
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                @array_walk_recursive($model->errors, function($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
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
     * Updates an existing MaterialType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post())) {
            $model->image_file = UploadedFile::getInstance($model, 'image_file');
            if ($model->save() && $model->upload()) {
                // file is uploaded successfully
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                @array_walk_recursive($model->errors, function($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
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
     * Deletes an existing MaterialType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MaterialType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaterialType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if (($model = MaterialType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
