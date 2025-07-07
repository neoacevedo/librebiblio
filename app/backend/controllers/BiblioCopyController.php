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

namespace backend\controllers;

use Yii;
use common\models\BiblioCopy;
use yii\filters\AccessControl;
use common\models\BiblioCopySearch;
use kartik\mpdf\Pdf;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BiblioCopyController implements the CRUD actions for BiblioCopy model.
 */
class BiblioCopyController extends Controller
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
                        //'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            $action = Yii::$app->controller->action->id;
                            $controller = Yii::$app->controller->id;
                            $route = "$controller/$action";
                            $roles = (array) Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
                            if (array_key_exists("admin", $roles)) {
                                return true;
                            }
                            //$post = Yii::$app->request->post();
                            return Yii::$app->user->can($route);
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
     * Lists all BiblioCopy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BiblioCopySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
    public function actionView(int $id, int $bibid)
    {

        return $this->render('view', [
            'model' => $this->findModel($id, $bibid),
        ]);
    }

    /**
     * Creates a new BiblioCopy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BiblioCopy();
        $biblio_status = \common\models\BiblioStatusDm::find()->all();

        $post = $this->request->post();
        if ($this->request->post('autoqrcode')) {
            $nzeros = "5";
            $copy_number = BiblioCopy::find()->where(['bibid' => $this->request->post("BiblioCopy")['bibid']])->max("id") + 1;
            $post['BiblioCopy']['barcode_nmbr'] = sprintf("%0" . $nzeros . "s", $this->request->post("BiblioCopy")['bibid']) . $copy_number;
        }

        if ($model->load($post)) {
            if (!$model->save()) {
                @array_walk_recursive($model->errors, function ($v, $k) {
                    Yii::$app->session->setFlash('error', $v);
                });
            }
            Yii::$app->session->setFlash('success', 'Copy registered correctly.');
            return $this->goBack($this->request->referrer);
        }
        return $this->renderAjax('create', [
            'model' => $model,
            'biblio_status' => $biblio_status
        ]);
    }

    /**
     * Updates an existing BiblioCopy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $bibid
     * @return mixed
     */
    public function actionUpdate(int $id, int $bibid)
    {
        $model = $this->findModel($id, $bibid);
        $biblio_status = \common\models\BiblioStatusDm::find()->all();

        if ($this->request->get('autoqrcode')) {
            $nzeros = "5";
            $copy_number = BiblioCopy::find()->where(['bibid' => $model->bibid])->max("id") + 1;
            $model->barcode_nmbr = sprintf("%0" . $nzeros . "s", $model->bibid) . $copy_number;
        }
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->save()) {
                @array_walk_recursive($model->errors, function ($v, $k) {
                    Yii::$app->session->setFlash('error', $v);
                });
            }
            Yii::$app->session->setFlash('success', 'Copy registered correctly.');
            return $this->goBack($this->request->referrer);
        }
        return $this->renderAjax('update', [
            'model' => $model,
            'biblio_status' => $biblio_status
        ]);
    }

    /**
     * Deletes an existing BiblioCopy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $bibid
     * @return mixed
     */
    public function actionDelete(int $id, int $bibid)
    {
        $this->findModel($id, $bibid)->delete();

        return $this->redirect(['cataloging/biblio/index']);
    }

    /**
     * Genera un PDF con el código QR de las copias bibliográficas.
     * @return string
     * @throws HttpException
     */
    public function actionCopiesPrint()
    {
        $searchModel = new BiblioCopySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        // return $this->render('copies-print', [
        //     'dataProvider' => $dataProvider,
        // ]);
        $html = $this->renderPartial('copies-print', [
            'dataProvider' => $dataProvider,
        ]);
        $pdf = new Pdf([
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => [
                'title' => '',
                'margin_left' => 25,
                'margin_right' => 25,
                'margin_top' => 25,
                'margin_bottom' => 25,
                'margin_header' => 10,
                'margin_footer' => 10,
                //'showBarcodeNumbers' => TRUE
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
     * Finds the BiblioCopy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $bibid
     * @return BiblioCopy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id, int $bibid)
    {
        if (($model = BiblioCopy::findOne(['id' => $id, 'bibid' => $bibid])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
