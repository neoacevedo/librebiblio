<?php
/**
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace frontend\controllers;

use common\models\BiblioStatusHistory;
use kartik\mpdf\Pdf;
use Yii;
use common\models\Member;
use common\models\MemberAccount;
use common\models\MemberAccountSearch;
use yii\web\Controller;
use yii\web\HttpException;
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
    public function behaviors()
    {
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
    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Muestra el historial de préstamos o reservas del miembro.
     * @return string
     */
    public function actionHistory(): string
    {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        $biblioStatusHist = BiblioStatusHistory::find()->where(['mbr_id' => $id]);
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

        return $this->render('history', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra el perfil del miembro.
     * @return string
     */
    public function actionProfile(): string
    {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);

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
     * @return string
     */
    public function actionAccount(): string
    {

        $id = Yii::$app->user->id;
        $model = $this->findModel($id);

        $searchModel = new MemberAccountSearch();
        $searchModel->mbr_id = $id;
        $dataProvider = $searchModel->search([]);


        return $this->render('account', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra los detalles de la cuenta actual del miembro.
     * @param integer $account_id
     * @return string
     */
    public function actionAccountView(int $account_id): string
    {
        $id = Yii::$app->user->id;
        $memberAccount = MemberAccount::findOne(['id' => $account_id, 'mbr_id' => $id]);


        return $this->renderAjax('account-view', [
            'memberAccount' => $memberAccount,
        ]);
    }

    /**
     * Convierte a PDF los detalles de la cuenta (multa, pago, etc) del miembro.
     * 
     * @param int $account_id
     * @return string
     * @throws HttpException
     */
    public function actionAccountPrint(int $account_id)
    {
        $id = Yii::$app->user->id;
        $memberAccount = MemberAccount::findOne(['id' => $account_id, 'mbr_id' => $id]);


        $html = $this->renderPartial('account-view', [
            'memberAccount' => $memberAccount,
        ]);

        $html = str_replace('<div class="row">', '<div class="hidden">', $html);

        $pdf = new Pdf([
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => [
                'margin_left' => 20,
                'margin_right' => 15,
                'margin_top' => 25,
                'margin_bottom' => 25,
                'margin_header' => 10,
                'margin_footer' => 10,
                'showBarcodeNumbers' => false
            ]
        ]);
        $pdf->content = $html;
        $pdf->methods = [
            'SetHeader' => [date('Y-m-d H:i:s')],
            'SetFooter' => [Yii::$app->name . '||{PAGENO}'],
        ];

        try {
            return $pdf->render();
        } catch (\Exception $e) {
            throw new HttpException(status: 500, message: $e->getMessage());
        }
    }

    /**
     * Muestra todas las reservas del miembro.
     * @return string
     */
    public function actionPlaceholds()
    {
        $id = Yii::$app->user->id;

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
     * @return string|\yii\web\Response
     */
    public function actionUpdate()
    {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("success", Yii::t('circulation', 'Member updated successfully'));
            return $this->redirect(['account']);
        } else {
            @array_walk_recursive($model->errors, function ($v, $k) {
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
    protected function findModel(int $id)
    {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {

            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
