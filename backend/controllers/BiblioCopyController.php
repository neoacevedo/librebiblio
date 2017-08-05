<?php

namespace backend\controllers;

use Yii;
use common\models\BiblioCopy;
use yii\filters\AccessControl;
use app\models\BiblioCopySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BiblioCopyController implements the CRUD actions for BiblioCopy model.
 */
class BiblioCopyController extends Controller {

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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($action) {
                            #$roles = \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                            if (Yii::$app->user->can('view') || Yii::$app->user->can('create') || Yii::$app->user->can('update') || Yii::$app->user->can('delete')) {
                                return true;
                            }
                            return false;
                        },
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
     * Lists all BiblioCopy models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BiblioCopySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BiblioCopy model.
     * @param integer $id
     * @param integer $bibid
     * @return mixed
     */
    public function actionView($id, $bibid) {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        return $this->render('view', [
                    'model' => $this->findModel($id, $bibid),
        ]);
    }

    /**
     * Creates a new BiblioCopy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new BiblioCopy();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'bibid' => $model->bibid]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BiblioCopy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $bibid
     * @return mixed
     */
    public function actionUpdate($id, $bibid) {
        $model = $this->findModel($id, $bibid);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'bibid' => $model->bibid]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BiblioCopy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $bibid
     * @return mixed
     */
    public function actionDelete($id, $bibid) {
        $this->findModel($id, $bibid)->delete();

        return $this->redirect(['cataloging/biblio/index']);
    }

    /**
     * Finds the BiblioCopy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $bibid
     * @return BiblioCopy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $bibid) {
        if (($model = BiblioCopy::findOne(['id' => $id, 'bibid' => $bibid])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
