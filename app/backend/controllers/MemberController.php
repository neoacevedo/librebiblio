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

use common\models\BiblioStatusHistorySearch;
use Yii;
use DateTime;
use common\models\Member;
use common\models\MemberAccount;
use common\models\MemberAccountSearch;
use backend\models\MemberSearch;
use frontend\models\PasswordResetRequestForm;
use kartik\mpdf\Pdf;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MemberController implementa las operaciones CRUD para el modelo Member
 *
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
                        //'actions' => $actions,
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
     * Lists all Member models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Registrar un miembro de la biblioteca desde la administración.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Member();
        $mbr_classify = Yii::$app->db->createCommand("Select * from {{%mbr_classify_dm}}")->queryAll();

        if ($model->load($this->request->post())) {
            $model->generateAuthKey();
            $model->generateEmailVerificationToken();
            $model->setPassword(time());
            if ($model->save()) {
                $passwordResetRequest = new PasswordResetRequestForm();
                $passwordResetRequest->email = $model->email;
                if ($passwordResetRequest->validate()) {
                    if ($passwordResetRequest->sendEmail()) {
                        Yii::$app->session->setFlash('success', Yii::t("app", "Mail sent to user."));
                    } else {
                        Yii::$app->session->setFlash('warning', Yii::t("app", "Mail couldn't be sent."));
                    }
                } else {
                    $message = "<ul>";
                    foreach ($passwordResetRequest->errors as $key => $error) {
                        $message .= "<li>{$error[0]}</li>";
                    }
                    $message .= "</ul>";
                    Yii::$app->session->setFlash('error', $message);
                }
                return $this->redirect(['index']);
            } else {
                @array_walk_recursive($model->errors, function ($v, $k) {
                    Yii::$app->getSession()->setFlash('error', $v);
                });
            }
        }

        return $this->render('create', [
            'model' => $model,
            'mbr_classify' => $mbr_classify
        ]);
    }

    /**
     * Deletes an existing Member model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Genera un PDF con un diseño básico con la información de los miembros de la biblioteca.
     * @return string
     * @throws HttpException
     */
    public function actionPrint(): string
    {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $html = $this->renderAjax('print', [
            'dataProvider' => $dataProvider,
        ]);

        $css = ".kv-heading-1{font-size:18px} 
                *, *::before, *::after{box-sizing: border-box} 
                .col-6 {
                    padding-right: 7.5px;
                    padding-left: 7.5px;
                    width: 50%;
                    height: auto;
                }
                .barcode {
                    display: block;
                    margin-left: 15px;
                    margin-right: 15px;
                    margin-bottom: 15px;
                }
                .fila {
                    margin-right: -7.5px;
                    margin-left: -7.5px;
                }";

        $pdf = new Pdf([
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => $css,
            'options' => [
                'margin_left' => 20,
                'margin_right' => 15,
                'margin_top' => 25,
                'margin_bottom' => 25,
                'margin_header' => 10,
                'margin_footer' => 10,
                'showBarcodeNumbers' => false,
            ]
        ]);
        $pdf->content = $html;
        $pdf->methods = [
            'SetHeader' => [date('Y-m-d H:i:s')],
            'SetTitle' => Yii::t('circulation', 'Print List'),
            'SetFooter' => [Yii::$app->name . '||{PAGENO}'],
        ];

        try {
            return $pdf->render();
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage());
        }
    }

    /**
     * Muestra el historial de préstamos del miembro de la biblioteca.
     * @return string
     */
    public function actionHistory()
    {
        $searchModel = new BiblioStatusHistorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('history', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Muestra los datos del miembro como su información básica, los materiales en préstamo o
     * reservados y las estadísticas en la biblioteca.
     * @param integer $id
     * @return string
     */
    public function actionView(int $id)
    {

        // estadísticas del usuario con los tipos de material registrados en la biblioteca
        if (Yii::$app->db->driverName === "mysql") {
            $materialTypeStats = (new \yii\db\Query())->select([
                "mat.*",
                "ifnull(privs.checkout_limit, 0) checkout_limit",
                "ifnull(privs.renewal_limit, 0) renewal_limit",
                "count(mbrout.copyid) row_count"
            ])->from("{{%material_type_dm}} mat")
                ->join('join', '{{%member}}')
                ->leftJoin('{{%checkout_privs}} privs', 'privs.material_cd = mat.id and privs.classification_id=member.classification_id')
                ->leftJoin('(select b.material_cd, c.bibid, c.id as copyid '
                    . 'from biblio_copy c, biblio b '
                    . 'where c.mbr_id=' . $id . ' and b.id=c.bibid) as mbrout', 'mbrout.material_cd = mat.id')
                ->where('{{%member}}.id = :id', [":id" => $id])
                ->groupBy(['mat.id', 'mat.description', 'mat.default_flg', 'privs.checkout_limit', 'privs.renewal_limit'])
                ->all();
        } elseif (Yii::$app->db->driverName === "pgsql") {
            $materialTypeStats = (new \yii\db\Query())->select([
                "mat.*",
                "nullif(privs.checkout_limit, 0) checkout_limit",
                "nullif(privs.renewal_limit, 0) renewal_limit",
                "count(mbrout.copyid) row_count"
            ])->from("{{%material_type_dm}} mat")
                ->join('cross join', '{{%member}}')
                ->leftJoin('{{%checkout_privs}} privs', 'privs.material_cd = mat.id and privs.classification_id = {{%member}}.classification_id')
                ->leftJoin('(select b.material_cd, c.bibid, c.id as copyid '
                    . 'from {{%biblio_copy}} c, biblio b '
                    . 'where c.mbr_id=' . $id . ' and b.id=c.bibid) as mbrout', 'mbrout.material_cd = mat.id')
                ->where('{{%member}}.id = :id', [":id" => $id])
                ->groupBy(['mat.id', 'mat.description', 'mat.default_flg', 'privs.checkout_limit', 'privs.renewal_limit'])
                ->orderBy('mat.id')
                ->all();
        }


        // status: checkout
        $biblioCopySearch[0] = new \common\models\BiblioCopySearch();
        $biblioCopySearch[0]->mbr_id = $id;
        $biblioCopySearch[0]->status_cd = 'out';
        $biblioCopy[0] = $biblioCopySearch[0]->search([]);
        // status: hold
        $biblioCopySearch[1] = new \common\models\BiblioHoldSearch();
        $biblioCopySearch[1]->mbr_id = $id;
        $biblioCopy[1] = $biblioCopySearch[1]->search([]);
        // copias bibliográficas
        $searchModel = new \common\models\BiblioCopySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // deudas
        $memberDebt = MemberAccount::find()->where(['mbr_id' => $id, "transaction_type_cd" => "+c"])->sum('amount');
        if ($memberDebt > 0) {
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Note: Member has an outstanding account balance of {0, number, currency}", $memberDebt));
        }

        $member = $this->findModel($id);
        if ($member->status == $member::STATUS_BLOCKED) {
            Yii::$app->getSession()->setFlash('error', Yii::t('circulation', "This member is currently blocked."));
        }
        return $this->render('view', [
            'model' => $member,
            'materialTypeStats' => $materialTypeStats,
            'biblioCopySearch' => $biblioCopySearch,
            'biblioCopy' => $biblioCopy,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Convierte a PDF los detalles de la cuenta (multa, pago, etc) del miembro.
     * @param int $id
     * @param int $mbr_id
     * @return string
     * @throws HttpException
     */
    public function actionAccountPrint($id, $mbr_id)
    {
        $memberAccount = MemberAccount::findOne(['id' => $id, 'mbr_id' => $mbr_id]);


        $html = $this->renderAjax('account-view', [
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
     * Actualiza la información del miembro.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $mbr_classify = Yii::$app->db->createCommand("Select * from {{%mbr_classify_dm}}")->queryAll();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("success", Yii::t('circulation', 'Member updated successfully'));
            return $this->redirect(['member-view', 'id' => $model->id]);
        } else {
            @array_walk_recursive($model->errors, function ($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
        }
        return $this->render('update', [
            'model' => $model,
            'mbr_classify' => $mbr_classify
        ]);
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
