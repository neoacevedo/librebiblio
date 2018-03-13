<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use DateTime;
use common\models\Member;
use common\models\MemberAccount;
use common\models\MemberAccountSearch;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use macklus\payments\Payment;
use macklus\payments\models\Payment as PaymentModel;
use yii\helpers\Html;

/**
 * Description of MemberController
 *
 * @author nestor
 */
class MemberController extends Controller {

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
                        'actions' => ['history', 'profile', 'account', 'account-view', 'account-print', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * Muestra el historial de préstamos o reservas del miembro.
     * @return mixed
     */
    public function actionHistory() {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        $biblioStatusHist = \common\models\BiblioStatusHistory::find()->where(['mbr_id' => $id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $biblioStatusHist,
        ]);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('history', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra el perfil del miembro.
     * @return mixed
     */
    public function actionProfile() {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('profile', [
                    'model' => $model,
        ]);
    }

    /**
     * Muestra la cuenta actual del miembro.
     * @return mixed
     */
    public function actionAccount() {

        $id = Yii::$app->user->id;
        $model = $this->findModel($id);

        $searchModel = new MemberAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('account', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra los detalles de la cuenta actual del miembro.
     * @param type $id
     * @param type $mbr_id
     * @return mixed
     */
    public function actionAccountView($id, $mbr_id) {
        $memberAccount = MemberAccount::findOne(['id' => $id, 'mbr_id' => $mbr_id]);
        
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->renderAjax('account-view', [
                    'memberAccount' => $memberAccount,
        ]);
    }

    /**
     * Convierte a PDF los detalles de la cuenta (multa, pago, etc) del miembro.
     * @param int $id
     * @param int $mbr_id
     * @return mixed
     */
    public function actionAccountPrint($id, $mbr_id) {
        $memberAccount = MemberAccount::findOne(['id' => $id, 'mbr_id' => $mbr_id]);
        
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        $html = $this->renderPartial('account-view', [
                    'memberAccount' => $memberAccount,
        ]);
        
        $html = str_replace('<div class="row">', '<div class="hidden">', $html);
        
        $pdf = Yii::$app->pdf;
        $pdf->content = $html;
        $pdf->options = ['margin_left' => 20,
            'margin_right' => 15,
            'margin_top' => 25,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10,
            'showBarcodeNumbers' => FALSE];
        $pdf->methods = [
            'SetHeader' => [date('Y-m-d H:i:s')],
            'SetFooter' => [Yii::$app->name . '||{PAGENO}'],
        ];

        try {
            return $pdf->render();
        } catch (\Exception $e) {
            return ($e->getMessage());
        }
    }

    /**
     * Actualiza la información del miembro.
     * @return mixed
     */
    public function actionUpdate() {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("success", Yii::t('circulation', 'Member updated successfully'));
            return $this->redirect(['account']);
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
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id) {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
