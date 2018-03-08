<?php

namespace backend\controllers;

use Yii;
use common\models\MemberAccount;
use common\models\MemberAccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MemberAccountController implements the CRUD actions for MemberAccount model.
 */
class MemberAccountController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MemberAccount models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MemberAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MemberAccount model.
     * @param integer $id
     * @param integer $mbr_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $mbr_id) {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('view', [
                    'model' => $this->findModel($id, $mbr_id),
        ]);
    }

    /**
     * Creates a new MemberAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new MemberAccount();
        $transactionType = \common\models\TransactionType::find()->all();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'mbr_id' => $model->mbr_id]);
        } else {
            @array_walk_recursive($model->errors, function($v, $k) {
                        Yii::$app->getSession()->setFlash('error', $v);
                    });
            return $this->render('create', [
                        'model' => $model,
                        'transactionType' => $transactionType
            ]);
        }
    }

    /**
     * Updates an existing MemberAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $mbr_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $mbr_id) {
        $model = $this->findModel($id, $mbr_id);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'mbr_id' => $model->mbr_id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MemberAccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $mbr_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $mbr_id) {
        $this->findModel($id, $mbr_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MemberAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $mbr_id
     * @return MemberAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $mbr_id) {
        if (($model = MemberAccount::findOne(['id' => $id, 'mbr_id' => $mbr_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('circulation', 'The requested page does not exist.'));
    }

}
