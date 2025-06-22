<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace frontend\controllers;

use Yii;
use common\models\Member;
use common\models\MemberAccount;
use common\models\MemberAccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MemberController implementa las operaciones CRUD para el modelo Member
 */
class MemberController extends Controller 
{

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['history', 'profile', 'account', 'account-view', 'account-print', 'placeholds', 'update'],
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
                'class' => VerbFilter::class,
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
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
            'sort' => [
                'attributes' => [
                    'copy.barcode_nmbr',
                    'bib.title',
                    'bib.author',
                    'copy.status_cd',
                    'created_at',
                    'due_back_dt',
                    'copy.renewal_count'
                ]
            ]
        ]);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('profile', [
                    'model' => $model,
        ]);
    }

    /**
     * Muestra la cuenta actual del miembro.
     * 
     * La lista muestra todos los tipos de cuenta creados para el usuario.
     * 
     * Los tipos de cuenta son:
     * <ul>
     *   <li>Cargo</li>
     *   <li>Pago</li>
     *   <li>Crédito.</li>
     * </ul>
     * @return mixed
     */
    public function actionAccount() {

        $id = Yii::$app->user->id;
        $model = $this->findModel($id);

        $searchModel = new MemberAccountSearch();
        $searchModel->mbr_id = $id;
        $dataProvider = $searchModel->search([]);

        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('account', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra los detalles de la cuenta actual del miembro.
     * @param integer $account_id
     * @return mixed
     */
    public function actionAccountView(int $account_id) {
        $id = Yii::$app->user->id;
        $memberAccount = MemberAccount::findOne(['id' => $account_id, 'mbr_id' => $id]);

        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->renderAjax('account-view', [
                    'memberAccount' => $memberAccount,
        ]);
    }

    /**
     * Convierte a PDF los detalles de la cuenta (multa, pago, etc) del miembro.
     * 
     * @param int $account_id
     * @return mixed
     */
    public function actionAccountPrint(int $account_id) {
        $id = Yii::$app->user->id;
        $memberAccount = MemberAccount::findOne(['id' => $account_id, 'mbr_id' => $id]);

        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
     * Muestra todas las reservas del miembro.
     * @return mixed
     */
    public function actionPlaceholds() {
        $id = Yii::$app->user->id;
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        $biblioCopySearch = new \common\models\BiblioHoldSearch();
        $biblioCopySearch->mbr_id = $id;
        $biblioCopy = $biblioCopySearch->search([]);
        
        return $this->render('placeholds', [
                    'model' => $this->findModel($id),
                    'searchModel' => $biblioCopySearch,
                    'dataProvider' => $biblioCopy
        ]);
    }


    /**
     * Actualiza la información del miembro.
     * @return mixed
     */
    public function actionUpdate() {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
            // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
