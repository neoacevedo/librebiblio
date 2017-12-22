<?php

namespace backend\controllers;

use Yii;
use DateTime;
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
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Busca un modelo Member que coincida con ciertas especificaciones.
     * @return mixed
     */
    public function actionSearch() {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('search', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lista todos los materiales bibliográficos que se encuentran en el carrito.
     * @return mixed
     */
    public function actionCart() {
        $searchModel = new \common\models\BiblioCopySearch();
        $searchModel->status_cd = 'crt';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('cart', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra una lista de copias bibliográficas.
     * La vista es renderizada vía ajax.
     * @return mixed
     */
    public function actionCopySearch() {
        $searchModel = new \common\models\BiblioCopySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->renderAjax('copysearch', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra una lista de copias bibliográficas que estén prestadas de manera local.
     * @return mixed
     */
    public function actionCheckin() {
        $searchModel = new \common\models\BiblioCopySearch();
        $searchModel->status_cd = 'out';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('checkin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Actualiza el estado de la copia bibliográfica y crea el historial para el miembro.
     * Los estados de la copia pueden ser:
     * <ul>
     * <li><i>crt</i> En el carrito</li>
     * <li><i>hld</i> En reserva</li>
     * <li><i>out</i> En préstamo</li>
     * <li><i>in</i> Disponible</li>
     * </ul>
     * @param int $bibid
     * @param int $copyid
     * @param string $status
     * @param int $id
     * @return mixed
     */
    public function actionCreate($bibid, $copyid, $status, $id) {

        $biblioCopy = \common\models\BiblioCopy::findOne(["id" => $copyid, "bibid" => $bibid]);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($id !== null) {
            $member = $this->findModel($id);
            if ($member->status == $member::STATUS_BLOCKED) {
                Yii::$app->getSession()->setFlash('error', Yii::t('circulation', "This member is currently blocked."));
                return $this->redirect(['member-view', 'id' => $id]);
            }
        }

        switch ($status) {
            case "crt":
                // una devolución
                if (!$this->shelving_cart($bibid, $copyid, $id)) {
                    return $this->redirect(['circulation/checkin']);
                }
                break;
            case "hld":
                // reserva
                $this->hold($bibid, $copyid, $id);
                $this->redirect(['member-view', 'id' => $id]);
            case "out":
                // préstamo
                if (!$this->checkout($bibid, $copyid, $id)) {
                    return $this->redirect(['member-view', 'id' => $id]);
                }
                break;
            case "in":
                // disponible
                if (!$this->checkin($bibid, $copyid, $id)) {
                    return $this->redirect(['circulation/checkin']);
                }
            default:
                break;
        }

        // verificar si el material bibliográfico ha alcanzado el límite de préstamos
        if ($biblioCopy->hasReachedCheckoutLimit($id, Member::findOne($id)->classification_id)) {
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Member has reached checkout limit for this collection."));
            return $this->redirect(['member-view', 'id' => $id]);
        }


        // crear el historial para el miembro
        $biblioStatusHistory = new \common\models\BiblioStatusHistory;
        $biblioStatusHistory->bibid = $bibid;
        $biblioStatusHistory->copyid = $copyid;
        $biblioStatusHistory->mbr_id = $id;
        $biblioStatusHistory->status_cd = $status;
        $biblioStatusHistory->created_at = date('Y-m-d H:i:s');
        // la fecha de devolución en el historial es la misma de la de la copia.
        if ($status == "crt") {
            $biblioCopy->due_back_dt = date('Y-m-d', strtotime($biblioCopy->due_back_dt));
        }
        if (!$biblioStatusHistory->save()) {
            array_walk_recursive($biblioStatusHistory->errors, function($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
        }
        // antes de hacer la purga, se debe revisar si tiene alguna deuda.
        $memberDebt = \common\models\MemberAccount::find()->where(['mbr_id' => $id])->sum('amount');
        if ($memberDebt == 0) {
            $purge_history_after_months = \common\models\Settings::find()->one()->purge_history_after_months;
            $oldBibStatus = \common\models\BiblioStatusHistory::find()->where(['<=', 'date(created_at)', "date_add(sysdate(),interval - $purge_history_after_months month)"])
                            ->andWhere(['mbr_id' => null])->all();

            foreach ($oldBibStatus as $ob) {
                $ob->delete();
            }
        }

        return $this->redirect(['member-view', 'id' => $id]);
    }

    /**
     * Borra una reserva de un usuario dado
     * @param int $id
     * @param int $mbr_id
     * @return mixed
     */
    public function actionHoldDelete($id, $mbr_id) {
        \common\models\BiblioHold::findOne($id)->delete();
        return $this->redirect(['member-view', 'id' => $mbr_id]);
    }

    /**
     * Updates an existing Member model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionMemberUpdate($id) {
        $model = $this->findModel($id);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['member-view', 'id' => $model->id]);
        } else {
            array_walk_recursive($model->errors, function($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
            return $this->render('member-update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Muestra el historial de préstamos del miembro.
     * @param int $id
     * @return mixed
     */
    public function actionMemberHistory($id) {
        $model = $this->findModel($id);
        $biblioStatusHist = \common\models\BiblioStatusHistory::find()->where(['mbr_id' => $id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $biblioStatusHist,
        ]);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('member-history', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Member model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionMemberDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Muestra los datos del miembro como su información básica, los materiales en préstamo o
     * reservados y las estadísticas en la biblioteca.
     * @param integer $id
     * @return mixed
     */
    public function actionMemberView($id) {
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
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Note: Member has an outstanding account balance of {0, number, currency}.", $memberDebt));
        }
        return $this->render('member-view', [
                    'model' => $this->findModel($id),
                    'materialTypeStats' => $materialTypeStats,
                    'biblioCopySearch' => $biblioCopySearch,
                    'biblioCopy' => $biblioCopy,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Registrar un miembro de la biblioteca desde la administración.
     * @return mixed
     */
    public function actionMemberCreate() {
        $model = new \backend\models\SignupForm();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Finds the Biblio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findBiblioModel($id) {
        if (($model = \common\models\Biblio::findOne($id)) !== null) {
            return $model;
        } else {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Finds the BiblioCopy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findCopyModel($bibid, $copyid) {
        if (($model = \common\models\BiblioCopy::findOne(["id" => $copyid, "bibid" => $bibid])) !== null) {
            return $model;
        } else {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Pone en reserva un material bibliográfico.
     * Valida si el material está en préstamo y si el material lo tiene otro miembro para proceder a la reserva.
     * También verifica si al miembro al que se le vaa reservar el material tiene alguna deuda; si la tiene,
     * no se realiza la reserva.
     * @param int $bibid
     * @param int $copyid
     * @param int $id
     * @return boolean
     */
    protected function hold($bibid, $copyid, $id) {
        $biblioCopy = $this->findCopyModel($bibid, $copyid);
        // si no está en préstamo o no está reservado (la reserva se debería buscar en la tabla biblio_hold)
        if ($biblioCopy->status_cd != "out" && $biblioCopy->status_cd != "hld") {
            // el material debe tener el estado "out" o "hld" para realizar una reserva
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "This item is not checked out or on hold."));
            return false;
        }

        // si el material está prestado y es el miembro quien lo tiene
        if ($biblioCopy->status_cd == 'out' && $biblioCopy->mbr_id == $id) {
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "This member already has that item checked out -- not placing hold."));
            return false;
        }

        if (null !== \common\models\BiblioHold::findOne(['copyid' => $copyid, 'bibid' => $bibid, 'mbr_id' => $id])) {
            // si el miembro ya ha reservado el material, se devuelve un aviso y no se reserva de nuevo el material.
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "This member already has that item placed hold -- not placing hold."));
            return false;
        } else {
            // Revisar si no tiene deuda. "+c" puede ser llamada de alguna constante o buscada de la tabla transaction_type_dm
            $memberDebt = \common\models\MemberAccount::find()->where(['mbr_id' => $id])->sum('amount');
            if ($memberDebt > 0) {
                Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Note: Member has an outstanding account balance of {0, number, currency}.", $memberDebt));
                // validar si no se permite que al usuario se le preste bibliografía si tiene deuda
                if (\common\models\Settings::find()->one()->block_checkouts_when_fines_due == 'Y') {
                    return false;
                }
            }

            $biblioHold = new \common\models\BiblioHold;
            $biblioHold->bibid = $bibid;
            $biblioHold->copyid = $copyid;
            $biblioHold->mbr_id = $id;
            $biblioHold->hold_begin_dt = date('Y-m-d H:i:s');

            if (!$biblioHold->save()) {
                array_walk_recursive($biblioHold->errors, function($v, $k) {
                    Yii::$app->getSession()->setFlash('error', $v);
                });
                return false;
            } else {
                Yii::$app->getSession()->setFlash('success', Yii::t('circulation', "Item placed hold."));
            }

            return true;
        }
    }

    /**
     * Realiza el préstamo de un material bibliográfico.
     * Verifica si al miembro al que se le va a prestar el material tiene alguna deuda; si la tiene, 
     * no se realiza el préstamo.
     * También verifica si el material está en préstamo y si el material lo tiene otro miembro para proceder al préstamo.
     * Valida también si el tipo de material ha alcanzado el límite de préstamos por parte del usuario.
     * @param int $bibid
     * @param int $copyid
     * @param int $id
     * @return boolean false si el miembro tiene una deuda, el material ya ha sido prestado o si el tipo de material ya ha alcanzado 
     * el límite de préstamos por parte del usuario.
     */
    protected function checkout($bibid, $copyid, $id) {
        $biblioCopy = $this->findCopyModel($bibid, $copyid);
        // Revisar si no tiene deuda. "+c" puede ser llamada de alguna constante o buscada de la tabla transaction_type_dm
        $memberDebt = \common\models\MemberAccount::find()->where(['mbr_id' => $id, "transaction_type_cd" => "+c"])->sum('amount');
        if ($memberDebt > 0) {
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Note: Member has an outstanding account balance of {0, number, currency}.", $memberDebt));
            // validar si no se permite que al usuario se le preste bibliografía si tiene deuda
            if (\common\models\Settings::find()->one()->block_checkouts_when_fines_due == 'Y') {
                return false;
            }
        }

        if ($biblioCopy->status_cd == 'hld') {
            if (($hold = \common\models\BiblioHold::findOne(['copyid' => $copyid, 'bibid' => $bibid, 'mbr_id' => $id])) !== null) {
                // el miembro fue quien reservó el material
                $holdMaxDays = \common\models\Settings::find()->one()->hold_max_days;
                $datetime1 = new DateTime($hold->created_at);
                $datetime2 = new DateTime('now');
                $interval = $datetime1->diff($datetime2);
                $diff = (int) $interval->format('%r%a');
                if ($holdMaxDays > 0 && $diff > $holdMaxDays) {
                    $tooOld = true;
                } else {
                    $tooOld = false;
                }
                if ($tooOld || $hold->mbr_id == $id) {
                    $hold->delete();
                } else {
                    // si otro miembro reservó antes el material
                    Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Item {n, number} is on hold to another member.", ['n' => $biblioCopy->barcode_nmbr]));
                    return false;
                }
            } else {
                // si otro miembro reservó antes el material
                Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Item {n, number} is on hold to another member.", ['n' => $biblioCopy->barcode_nmbr]));
                return false;
            }
        }

        if ($biblioCopy->status_cd == 'out' && $biblioCopy->mbr_id == $id) {
            // el miembro tiene el material
            if ($biblioCopy->hasReachedRenewalLimit(Member::findOne($id)->classification_id)) {
                // el miembro ya alcanzó el límite de renovaciones
                Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Item {n, number} has reached its renewal limit.", ['n' => $biblioCopy->barcode_nmbr]));
                return false;
            }

            if ($biblioCopy->due_back_dt < date('Y-m-d', strtotime('now'))) {
                // el material no ha sido devuelto en el tiempo establecido.
                Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Item {n, number} is late and cannot be renewed.", ['n' => $biblioCopy->barcode_nmbr]));
                return false;
            }
            $biblioCopy->renewal_count = $biblioCopy->renewal_count + 1;
            $biblioCopy->updated_at = date('Y-m-d H:i:s');
            // la fecha de devolución se amplía basado en la fecha de devolución inicial.
            $collection = \backend\models\Collection::findOne(\common\models\Biblio::findOne($bibid)->collection_cd);
            $biblioCopy->due_back_dt = date('Y-m-d H:i:s', strtotime($biblioCopy->due_back_dt) + $collection->days_due_back);
        } elseif ($biblioCopy->status_cd == 'out' && $biblioCopy->mbr_id != $id) {
            // si otro miembro tiene el material
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Item {n, number} is already checked out to another member.", ['n' => $biblioCopy->barcode_nmbr]));
            return false;
        } elseif ($biblioCopy->status_cd == 'in') {
            // nadie tiene el material. Se puede prestar.
            $biblioCopy->status_begin_dt = date('Y-m-d H:i:s');
            $biblioCopy->due_back_dt = date('Y-m-d H:i:s', strtotime($biblioCopy->status_begin_dt) + $collection->days_due_back);
        }
        $biblioCopy->mbr_id = $id;
        $biblioCopy->status_cd = 'out';
        $biblioCopy->updated_at = date('Y-m-d H:i:s');
        if (!$biblioCopy->save()) {
            array_walk_recursive($biblioCopy->errors, function($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
            return false;
        }
        return true;
    }

    /**
     * Cambia el estado de la copia bibliográfica.
     * El estado de la copia puede ser: 
     * <i>crt</i> En el carrito
     * <i>hld</i> Rservado
     * Este es el paso previo a devolverlo a la estantería, prestarlo o marcarlo con algún otro estado diferente 
     * dependiendo de las coneiciones en que haya sido devuelto el material bibliográfico.
     * @param int $bibid
     * @param int $copyid
     * @param int $id
     * @return boolean
     */
    protected function shelving_cart($bibid, $copyid, $id) {
        $biblioCopy = $this->findCopyModel($bibid, $copyid);

        // buscar si ya hay una solicitud de reserva y cambiar el estado de la copia a "en reserva" si hay una reserva.
        if (($hold = \common\models\BiblioHold::findOne(['copyid' => $copyid, 'bibid' => $bibid])) !== null) {
            $biblioCopy->status_cd = 'hld';
            Yii::$app->getSession()->setFlash('info', Yii::t('circulation', 'The bibliography with barcode number {barcode} that you are attempting to check in has one or more hold requests placed on it.  <b>Please file this bibliography with your held items instead of placing it on your shelving cart.</b>  The status code for this bibliography has been set to hold.'));
        } else {
            $biblioCopy->status_cd = 'crt';
        }

        $biblioCopy->mbr_id = null;
        $biblioCopy->status_begin_dt = date('Y-m-d H:i:s', strtotime($biblioCopy->status_begin_dt) + 1);
        $biblioCopy->due_back_dt = null;
        $biblioCopy->updated_at = date('Y-m-d H:i:s');
        if (!$biblioCopy->save()) {
            array_walk_recursive($biblioCopy->errors, function($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
            return false;
        }

        return true;
    }

    /**
     * Cambia el estado del material bibliográfico a disponible.
     * 
     * Se evalúa si el miembro que devuelve el libro lo devuelve en una fecha <br />
     * posterior a la establecida, genera la multa correspondiente y bloquea la <br />
     * cuenta del usuario para nuevos préstamos externos.
     * @param int $bibid
     * @param int $copyid
     * @param int $id
     * @return boolean
     */
    protected function checkin($bibid, $copyid, $id) {
        $late = $fee = 0; // se definen estas dos variables de tipo entero
        $biblio = $this->findBiblioModel($bibid);
        // encontrar el cargo por día de retraso
        $fee = $biblio->getCollection()->one()->daily_late_fee;
        $biblioCopy = $this->findCopyModel($bibid, $copyid);

        if (null !== $biblioCopy->due_back_dt) {
            if (strtotime($biblioCopy->due_back_dt) !== false && strtotime($biblioCopy->due_back_dt) !== -1) {
                $late = (new DateTime($biblioCopy->due_back_dt))->diff(new DateTime());
            }
        }
        
        $biblioCopy->due_back_dt = null;
        $biblioCopy->mbr_id = null;

        if ($late > 0 && $fee > 0) {
            $trans = new \common\models\MemberAccount;
            $trans->mbr_id = $id;
            $trans->create_userid = Yii::$app->user->id;
            $trans->created_at = date('Y-m-d H:i:s');
            $trans->transaction_type_cd = "+c";
            $trans->amount = $fee * $late;
            $trans->description = Yii::t('circulation', "Late fee (barcode={n, number})", ['n' => $biblioCopy->barcode_nmbr]);
            if (!$trans->save()) {
                array_walk_recursive($trans->errors, function($v, $k) {
                    Yii::$app->getSession()->setFlash('error', $v);
                });
                return false;
            }

            $member = $this->findModel($id);
            $member->status = Member::STATUS_BLOCKED;
            $member->save();
        }
        return true;
    }

}
