<?php

namespace backend\controllers;

use Yii;
use DateTime;
use common\models\Member;
use common\models\MemberAccount;
use common\models\MemberAccountSearch;
use backend\models\MemberSearch;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                        //'actions' => $actions,
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            /* $roles = (array) Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                              if (array_key_exists("admin", $roles)) {
                              return true;
                              }
                              return Yii::$app->authManager->checkAccess(\Yii::$app->user->getId(), $this->action->id); */
                            $action = Yii::$app->controller->action->id;
                            $controller = Yii::$app->controller->id;
                            $route = "$controller/$action";
                            $roles = (array) Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                            if (array_key_exists("admin", $roles)) {
                                return true;
                            }
                            //$post = Yii::$app->request->post();
                            if (\Yii::$app->user->can($route)) {
                                return true;
                            }
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
     * Registrar un miembro de la biblioteca desde la administración.
     * @return mixed
     */
    public function actionCreate() {
        $model = new \common\models\SignupForm();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if ($model->sendEmail($user->id)) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Email sent to user'));
                } else {
                    Yii::$app->getSession()->setFlash('warning', 'Failed, contact Admin!');
                }
                return $this->redirect(['circulation/index']);
            }
        } else {
            @array_walk_recursive($model->errors, function($v, $k) {
                        Yii::$app->getSession()->setFlash('error', $v);
                    });
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Member model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Genera un PDF con un diseño básico con la información de los miembros de la biblioteca.
     * @return mixed
     */
    public function actionPrint() {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        /* return $this->render('members-print', [
          'dataProvider' => $dataProvider,
          ]); */
        $html = $this->renderPartial('print', [
            'dataProvider' => $dataProvider,
        ]);
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
     * Muestra el historial de préstamos del miembro.
     * @param integer $id
     * @return mixed
     */
    public function actionHistory(int $id) {
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
     * Muestra los datos del miembro como su información básica, los materiales en préstamo o
     * reservados y las estadísticas en la biblioteca.
     * @param integer $id
     * @return mixed
     */
    public function actionView(int $id) {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
// estadísticas del usuario con los tipos de material registrados en la biblioteca
        $materialTypeStats = (new \yii\db\Query)->select(["mat.*", "ifnull(privs.checkout_limit, 0) checkout_limit",
                    "ifnull(privs.renewal_limit, 0) renewal_limit", "count(mbrout.copyid) row_count"
                ])->from("{{%material_type_dm}} mat")
                ->join('join', '{{%member}}')
                ->leftJoin('{{%checkout_privs}} privs', 'privs.material_cd = mat.id and privs.classification_id=member.classification_id')
                ->leftJoin('(select b.material_cd, c.bibid, c.id as copyid '
                        . 'from biblio_copy c, biblio b '
                        . 'where c.mbr_id=' . $id . ' and b.id=c.bibid) as mbrout', 'mbrout.material_cd = mat.id')
                ->where('{{%member}}.id = :id', [":id" => $id])
                ->groupBy(['mat.id', 'mat.description', 'mat.default_flg', 'privs.checkout_limit', 'privs.renewal_limit'])
                ->all();


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
        $memberDebt = \common\models\MemberAccount::find()->where(['mbr_id' => $id, "transaction_type_cd" => "+c"])->sum('amount');
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
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate(int $id) {
        $model = $this->findModel($id);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("success", Yii::t('circulation', 'Member updated successfully'));
            return $this->redirect(['member-view', 'id' => $model->id]);
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
