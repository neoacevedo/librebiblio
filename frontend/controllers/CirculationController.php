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
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
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
                //'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            //throw new \Exception('You are not allowed to access this page');
                            if ($action->id == "create") {
                                $model = $this->findModel(Yii::$app->user->id);
                                if ($model->status == $model::STATUS_BLOCKED) {
                                    \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
                                    throw new ForbiddenHttpException(Yii::t('app', 'You are not allowed to perform this action.'));
                                }
                            }

                            return true;
                        },
                    ],
                    [
                        'actions' => ['history'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
        $this->updateMemberAccount($id);
        
        $memberDebt = \common\models\MemberAccount::find()->where(['mbr_id' => $id, "transaction_type_cd" => "+c"])->sum('amount');
        if ($memberDebt > 0) {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Note: Member has an outstanding account balance of {0, number, currency}.", $memberDebt));
            // validar si no se permite que al usuario se le preste bibliografía si tiene deuda
            if (\common\models\Settings::find()->one()->block_checkouts_when_fines_due == 'Y') {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        //$due_back = 7 * 24 * 60 * 60; // Esto será configurable. Determinará el tiempo de devolución
        $biblioCopy = \common\models\BiblioCopy::findOne(["id" => $copyid, "bibid" => $bibid]);
        
        if ($biblioCopy->status_cd != "out" && $biblioCopy->status_cd != "hld") {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "This item is not checked out or on hold."));
            return $this->redirect(Yii::$app->request->referrer);
        }

        if ($biblioCopy->status_cd == 'out' && $biblioCopy->mbr_id == $id) {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "This member already has that item checked out -- not placing hold."));
        }

        if (null !== \common\models\BiblioHold::findOne(['copyid' => $copyid, 'bibid' => $bibid, 'mbr_id' => $id])) {
            // si el miembro ya ha reservado el material, se devuelve un aviso y no se reserva de nuevo el material.
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "This member already has that item placed hold -- not placing hold."));
        } else {

            $biblioHold = new \common\models\BiblioHold;
            $biblioHold->bibid = $bibid;
            $biblioHold->copyid = $copyid;
            $biblioHold->mbr_id = $id;
            $biblioHold->hold_begin_dt = date('Y-m-d H:i:s');

            if (!$biblioHold->save()) {
                array_walk_recursive($biblioStatusHistory->errors, function($v, $k) {
                    Yii::$app->getSession()->setFlash('error', $v);
                });
            } else {
                \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
                Yii::$app->getSession()->setFlash('success', Yii::t('circulation', "Item placed hold."));
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionHistory($id) {
        $model = $this->findModel($id);
        $biblioStatusHist = \common\models\BiblioStatusHistory::find()->where(['mbr_id' => $id]);
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
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id) {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Actualiza o crea una nueva deuda.
     * @param int $mbrid
     */
    protected function updateMemberAccount(int $mbrid) {
        $late = $fee = 0; // se definen estas dos variables de tipo entero

        $biblioCopies = \common\models\BiblioCopy::find()->where(['mbr_id' => $mbrid])->all();

        foreach ($biblioCopies as $biblioCopy) {

            $biblio = \common\models\Biblio::findOne($biblioCopy->bibid);
            // encontrar el cargo por día de retraso
            $fee = $biblio->getCollection()->one()->daily_late_fee;

            if (null !== $biblioCopy->due_back_dt) {
                if (strtotime($biblioCopy->due_back_dt) !== false && strtotime($biblioCopy->due_back_dt) !== -1) {
                    $dt = new DateTime($biblioCopy->due_back_dt);
                    $now = new DateTime("now");
                    $dtdiff = $dt->diff($now);
                    $late = $dtdiff->format("%a");
                }
            }

            if ($mbrid != "" and $late > 0 and $fee > 0) {
                $trans = new \common\models\MemberAccount;
                $trans->mbr_id = $mbrid;
                $trans->create_userid = Yii::$app->user->id;
                $trans->created_at = date('Y-m-d H:i:s');
                $trans->transaction_type_cd = "+c";
                $trans->amount = $fee * $late;
                $trans->description = Yii::t('circulation', "Late fee (barcode={n, number})", ['n' => $biblioCopy->barcode_nmbr]);
                if (!$trans->save()) {
                    array_walk_recursive($trans->errors, function($v, $k) {
                        Yii::$app->getSession()->setFlash('error', $v);
                    });
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    $member = $this->findModel($mbrid);
                    $member->status = Member::STATUS_BLOCKED;
                    $member->save();
                }
            }
        }
    }

}
