<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use common\models\Member;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Biblio;
use common\models\BiblioSearch;

/**
 * Description of CirculationController
 *
 * @author nestor
 */
class CirculationController extends Controller {
    //put your code here

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        //return $this->render('index');
        $searchModel = new BiblioSearch();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Crea una reserva de un material bibliográfico.
     * @todo Queda pendiente que el propio miembro pueda solicitar en préstamo un material.
     * @param int $id
     * @param int $bibid
     * @param int $copyid
     * @param string $status
     * @return mixed
     */
    public function actionCreate($bibid, $copyid, $id) {

        //$due_back = 7 * 24 * 60 * 60; // Esto será configurable. Determinará el tiempo de devolución
        $biblioCopy = \common\models\BiblioCopy::findOne(["id" => $copyid, "bibid" => $bibid]);

        if ($biblioCopy->status_cd != "out" && $biblioCopy->status_cd != "hld") {
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "This item is not checked out or on hold."));
            return $this->redirect(Yii::$app->request->referrer);
        } 
        
        if ($biblioCopy->status_cd == 'out' && $biblioCopy->mbr_id == $id) {
                Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "This member already has that item checked out -- not placing hold."));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionHistory($id) {
        $model = $this->findModel($id);
        $biblioStatusHist = \common\models\BiblioStatusHistory::find(['bibid' => $id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $biblioStatusHist,
        ]);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        return $this->render('history', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
