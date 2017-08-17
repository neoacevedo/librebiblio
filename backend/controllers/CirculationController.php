<?php

namespace backend\controllers;

use Yii;
use common\models\Member;
use backend\models\MemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CirculationController implements the CRUD actions for User model.
 */
class CirculationController extends Controller {

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
                        //'actions' => ['index', 'search', 'new-member', 'member-view', 'member-update', 'member-delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            $roles = (array) Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                            //Yii::info($roles);
                            if (array_key_exists("admin", $roles)) {
                                return true;
                            }
                            return Yii::$app->authManager->checkAccess(\Yii::$app->user->getId(), $this->action->id);
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra los datos del miembro como su información básica, los materiales en préstamo o
     * reservados y las estadísticas en la biblioteca.
     * @param integer $id
     * @return mixed
     */
    public function actionMemberView($id) {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
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
        $biblioCopySearch[0] = new \app\models\BiblioCopySearch();
        $biblioCopySearch[0]->mbr_id = $id;
        $biblioCopySearch[0]->status_cd = 'out';
        $biblioCopy[0] = $biblioCopySearch[0]->search([]);
// status: hold
        $biblioCopySearch[1] = new \app\models\BiblioCopySearch();
        $biblioCopySearch[1]->mbr_id = $id;
        $biblioCopySearch[1]->status_cd = 'hld';
        $biblioCopy[1] = $biblioCopySearch[1]->search([]);
// copias bibliográficas
        $searchModel = new \app\models\BiblioCopySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('member-view', [
                    'model' => $this->findModel($id),
                    'materialTypeStats' => $materialTypeStats,
                    'biblioCopySearch' => $biblioCopySearch,
                    'biblioCopy' => $biblioCopy,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionSearch() {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        return $this->render('search', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCopySearch() {
        $searchModel = new \app\models\BiblioCopySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        return $this->renderAjax('copysearch', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        /* if (Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
          return $this->renderAjax('copysearch', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          ]);
          } else {
          return $this->renderAjax('copysearch', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          ]);
          } */
    }

    public function actionCheckin() {
        $searchModel = new \app\models\BiblioCopySearch();
        $searchModel->status_cd = 'out';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        return $this->render('checkin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Registrar un usuario de la biblioteca desde la administración.
     * @return mixed
     */
    public function actionNewMember() {
        $model = new \backend\models\SignupForm();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $email = \Yii::$app->mailer->compose()
                        ->setTo($user->email)
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                        ->setSubject('Signup Confirmation')
                        ->setTextBody("")
                        ->send();
                if ($email) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Email sent to user'));
                } else {
                    Yii::$app->getSession()->setFlash('warning', 'Failed, contact Admin!');
                }
                return $this->redirect(['circulation/index']);
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    /**
     * Actualiza el estado de la copia bibliográfica y crea el historial para el miembro.
     * @param int $id
     * @param int $bibid
     * @param int $copyid
     * @param string $status
     * @return mixed
     */
    public function actionCreate($bibid, $copyid, $status, $id = 0) {

        $due_back = 7 * 24 * 60 * 60; // Esto será configurable. Determinará el tiempo de devolución
        $biblioCopy = \common\models\BiblioCopy::findOne(["id" => $copyid, "bibid" => $bibid]);
        // si se env�a el id del miembro y el estado no es 'in', se procede como si fuera una reserva o un pr�stamo interno.
        if ($id != 0) {
            if ($biblioCopy->status_cd == 'out' && $biblioCopy->mbr_id == $id) {
                // si ya el miembro tiene el material...
                // se renueva el item
                $biblioCopy->renewal_count = $biblioCopy->renewal_count + 1;
                $biblioCopy->updated_at = date('Y-m-d H:i:s');
                // la fecha de devolución se amplía basado en la fecha de devolución inicial.
                $biblioCopy->due_back_dt = date('Y-m-d H:i:s', strtotime($biblioCopy->due_back_dt) + $due_back);
            } elseif ($biblioCopy->status_cd == 'out' && $biblioCopy->mbr_id != $id) {
                // si otro miembro se llevó el material
                Yii::$app->getSession()->setFlash('warning', Yii::t('app', "Item $biblioCopy->barcode_nmbr is already checked out to another member."));
                return $this->redirect(['member-view', 'id' => $id]);
            } else {
                // hasta ahora se va a tomar en préstamo, solo se genera la fecha de devolución a la establecida.
                $biblioCopy->due_back_dt = date('Y-m-d H:i:s', strtotime('now') + $due_back);
            }
        }

        if ($status == "in") {
            $biblioCopy->due_back_dt = null;
        }

        $biblioCopy->mbr_id = $id;
        $biblioCopy->status_cd = $status;
        $biblioCopy->updated_at = date('Y-m-d H:i:s');
        if ($biblioCopy->save()) {
            // crear el historial para el miembro
            $biblioStatusHistory = new \common\models\BiblioStatusHistory;
            $biblioStatusHistory->bibid = $bibid;
            $biblioStatusHistory->copyid = $copyid;
            $biblioStatusHistory->mbr_id = $id;
            $biblioStatusHistory->status_cd = 'out';
            $biblioStatusHistory->created_at = date('Y-m-d H:i:s');
            // la fecha de devolución en el historial es la misma de la de la copia.
            $biblioStatusHistory->due_back_dt = date('Y-m-d', strtotime($biblioCopy->due_back_dt));
            $biblioStatusHistory->renewal_count = $biblioCopy->renewal_count;
            if (!$biblioStatusHistory->save()) {
                var_dump($biblioStatusHistory->getErrors());
                exit;
                $errors = array_map(function($v) {
                    return $v;
                }, $biblioStatusHistory->getErrors());
                Yii::$app->getSession()->setFlash('error', implode("<br />", $errors));
            }
        } else {
            Yii::error(var_export($biblioCopy->getErrors()), 'CirculationController');
            $errors = array_map(function($v) {
                return $v;
            }, $biblioCopy->getErrors());
            Yii::$app->getSession()->setFlash('error', implode("<br />", $errors));
        }

        return $id != 0 ? $this->redirect(['member-view', 'id' => $id]) : $this->redirect(['index']);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionMemberUpdate($id) {
        $model = $this->findModel($id);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(['es-CO', 'es-ES', 'en-GB']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('member-update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionMemberDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
