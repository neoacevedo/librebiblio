<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

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
 * CirculationController implementa las acciones CRUD para el préstamo o reserva de materiales bibliográficos.
 */
class CirculationController extends Controller
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
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
    public function actionIndex()
    {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Busca un modelo Member que coincida con ciertas especificaciones.
     * @return mixed
     */
    public function actionSearch()
    {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lista todos los materiales bibliográficos que se encuentran en el carrito.
     * @return mixed
     */
    public function actionCart()
    {
        $searchModel = new \common\models\BiblioCopySearch();
        $searchModel->status_cd = 'crt';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
    public function actionCopySearch()
    {
        $searchModel = new \common\models\BiblioCopySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->renderAjax('copysearch', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Cambia el estado de la copia a disponible y muestra una lista de copias
     * bibliográficas que estén en el carrito.
     * @param int $copyid
     * @param int $bibid
     * @return type
     */
    public function actionCheckin(int $copyid, int $bibid)
    {
        $model = $this->findCopyModel($bibid, $copyid);
        $model->status_cd = 'in';
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);

        if ($model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash("sucess", Yii::t('circulation', 'Checked in {barcode}', $model->barcode_nmbr));
        } else {
            array_walk_recursive($model->errors, function ($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
        }

        $this->redirect(['circulation/cart']);
    }

    /**
     * Registra un préstamo o reserva de la copia bibliográfica y crea el historial para el miembro.
     * Los estados de la copia pueden ser:
     * <ul>
     * <li><i>crt</i> En el carrito</li>
     * <li><i>hld</i> En reserva</li>
     * <li><i>out</i> En préstamo</li>
     * <li><i>in</i> Disponible</li>
     * </ul>
     * @param int $bibid ID del material
     * @param int $copyid ID de la copia
     * @param string $status
     * @param int $id ID del socio de la biblioteca que solicita el préstamo o reserva.
     * @return mixed
     */
    public function actionCreate(int $bibid, int $copyid, string $status, int $id)
    {
        if ($status === "crt") {
            // una devolución
            $this->shelving_cart($bibid, $copyid, $id);
            return $this->redirect(['circulation/reception']);
        }
        switch ($status) {
            case "hld":
                // reserva
                $this->hold($bibid, $copyid, $id);
                break;
            case "out":
                // préstamo
                $this->checkout($bibid, $copyid, $id);
                break;
            default:
                break;
        }

        $this->redirect($this->request->referrer);
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
    public function actionUpdate(int $bibid, int $copyid, string $status, int $id)
    {
        switch ($status) {
            case "crt":
                // una devolución
                $this->shelving_cart($bibid, $copyid, $id);
                return $this->redirect(['circulation/reception']);
            default:
                break;
        }
    }

    /**
     * Muestra una lista de copias bibliográficas que estén prestadas de manera local.
     * @return type
     */
    public function actionReception()
    {
        $searchModel = new \common\models\BiblioCopySearch();
        $searchModel->status_cd = 'out';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('checkin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Borra una reserva de un usuario dado.
     * Cuando borra la reserva, el material pasa al carrito.
     * @param int $id
     * @param int $mbr_id
     * @return mixed
     */
    public function actionHoldDelete(int $id, int $mbr_id)
    {
        $biblioHold = \common\models\BiblioHold::findOne($id);
        $biblioCopy = $this->findCopyModel($biblioHold->bibid, $biblioHold->copyid);
        $biblioHold->delete();
        if ($biblioCopy->status_cd === "hld") {
            $biblioCopy->status_cd = "in";
            $biblioCopy->status_begin_dt = date('Y-m-d H:i:s');
            $biblioCopy->save();
        }
        return $this->redirect(['member/view', 'id' => $mbr_id]);
    }

    /**
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
    protected function findBiblioModel(int $id)
    {
        if (($model = \common\models\Biblio::findOne($id)) !== null) {
            return $model;
        } else {
            // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
    protected function findCopyModel(int $bibid, int $copyid)
    {
        if (($model = \common\models\BiblioCopy::findOne(["id" => $copyid, "bibid" => $bibid])) !== null) {
            return $model;
        } else {
            // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Pone en reserva un material bibliográfico.
     * Valida si el material está en préstamo y si el material lo tiene otro miembro para proceder a la reserva.<br />
     * También verifica si al miembro al que se le vaa reservar el material tiene alguna deuda; si la tiene,
     * no se realiza la reserva.
     * @param int $bibid
     * @param int $copyid
     * @param int $id
     * @return boolean
     */
    protected function hold(int $bibid, int $copyid, int $id)
    {
        $biblioCopy = $this->findCopyModel($bibid, $copyid);
        // si no está en préstamo o no está reservado (la reserva se debería buscar en la tabla biblio_hold)
        if ($biblioCopy->status_cd !== "out" && $biblioCopy->status_cd !== "hld") {
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
            //
            $member = $this->findModel($id);
            if ($member->status == $member::STATUS_BLOCKED) {
                Yii::$app->getSession()->setFlash('error', Yii::t('circulation', "This member is currently blocked."));
                return $this->redirect(['member/view', 'id' => $id]);
            }
            // Revisar si no tiene deuda. "+c" puede ser llamada de alguna constante o buscada de la tabla transaction_type_dm
            $memberDebt = \common\models\MemberAccount::find()->where(['mbr_id' => $id])->sum('amount');
            if ($memberDebt > 0) {
                Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Note: Member has an outstanding account balance of {0, number, currency}", $memberDebt));
                // validar si no se permite que al usuario se le preste bibliografía si tiene deuda
                if (\common\models\Settings::find()->one()->block_checkouts_when_fines_due == 'Y') {
                    return false;
                }
            }

            $biblioHold = new \common\models\BiblioHold();
            $biblioHold->bibid = $bibid;
            $biblioHold->copyid = $copyid;
            $biblioHold->mbr_id = $id;
            $biblioHold->hold_begin_dt = date('Y-m-d H:i:s');

            if (!$biblioHold->save()) {
                array_walk_recursive($biblioHold->errors, function ($v, $k) {
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
    protected function checkout(int $bibid, int $copyid, int $id)
    {
        $biblioCopy = $this->findCopyModel($bibid, $copyid);
        // Revisar si no tiene deuda. "+c" puede ser llamada de alguna constante o buscada de la tabla transaction_type_dm
        $memberDebt = \common\models\MemberAccount::find()->where(['mbr_id' => $id, "transaction_type_cd" => "+c"])->sum('amount');
        if ($memberDebt > 0) {
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Note: Member has an outstanding account balance of {0, number, currency}", $memberDebt));
            // validar si no se permite que al usuario se le preste bibliografía si tiene deuda
            if (\common\models\Settings::find()->one()->block_checkouts_when_fines_due == 'Y') {
                return false;
            }
        }

        $collection = \backend\models\Collection::findOne(\common\models\Biblio::findOne($bibid)->collection_cd);

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
            // el miembro tiene el material. Buscar si ya alcanzó el límite de renovaciones.
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
            $biblioCopy->due_back_dt = date('Y-m-d H:i:s', strtotime($biblioCopy->due_back_dt) + $collection->days_due_back);
        } elseif ($biblioCopy->status_cd == 'out' && $biblioCopy->mbr_id != $id) {
            // si otro miembro tiene el material
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Item {n, number} is already checked out to another member.", ['n' => $biblioCopy->barcode_nmbr]));
            return false;
        } elseif ($biblioCopy->status_cd == 'in') {
            // nadie tiene el material. Se puede prestar.
            $biblioCopy->status_begin_dt = date('Y-m-d H:i:s');
            $biblioCopy->due_back_dt = date('Y-m-d H:i:s', strtotime("now +{$collection->days_due_back} days"));
        }

        // verificar si el miembro ya alcanzó el límite de pŕestamos.
        if ($biblioCopy->hasReachedCheckoutLimit($id, Member::findOne($id)->classification_id)) {
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Member has reached checkout limit for this collection."));
            return $this->redirect(['member/view', 'id' => $id]);
        }
        $biblioCopy->mbr_id = $id;
        $biblioCopy->status_cd = 'out';
        $biblioCopy->updated_at = date('Y-m-d H:i:s');
        if (!$biblioCopy->save()) {
            array_walk_recursive($biblioCopy->errors, function ($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
            return false;
        }

        // crear el historial para el miembro
        $biblioStatusHistory = new \common\models\BiblioStatusHistory();
        $biblioStatusHistory->bibid = $bibid;
        $biblioStatusHistory->copyid = $copyid;
        $biblioStatusHistory->mbr_id = $id;
        $biblioStatusHistory->status_cd = 'out';
        $biblioStatusHistory->created_at = date('Y-m-d H:i:s');
        $biblioStatusHistory->due_back_dt = date('Y-m-d', strtotime($biblioCopy->due_back_dt));

        if (!$biblioStatusHistory->save()) {
            array_walk_recursive($biblioStatusHistory->errors, function ($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
        }
        // antes de hacer la purga, se debe revisar si tiene alguna deuda.
        //$memberDebt = \common\models\MemberAccount::find()->where(['mbr_id' => $id])->sum('amount');
        if ($memberDebt == 0) {
            $purge_history_after_months = \common\models\Settings::find()->one()->purge_history_after_months;
            $oldBibStatus = \common\models\BiblioStatusHistory::find()->where(['<=', 'date(created_at)', "date_add(sysdate(),interval - $purge_history_after_months month)"])
                ->andWhere(['mbr_id' => null])->all();

            foreach ($oldBibStatus as $ob) {
                $ob->delete();
            }
        }

        return true;
    }

    /**
     * Pone el material bibliográfico en el carrito y Cambia el estado de la copia bibliográfica.
     * El estado de la copia puede ser:
     * <ul>
     *  <li><i>crt</i>: En el carrito</li>
     *  <li><i>hld</i>: Rservado</li>
     * </ul>
     * Este es el paso previo a devolverlo a la estantería, prestarlo o marcarlo con algún otro estado diferente
     * dependiendo de las condiciones en que haya sido devuelto el material bibliográfico.
     * @param int $bibid
     * @param int $copyid
     * @param int $id
     * @return boolean
     */
    protected function shelving_cart(int $bibid, int $copyid, int $id)
    {
        $biblioCopy = $this->findCopyModel($bibid, $copyid);

        // buscar si ya hay una solicitud de reserva y cambiar el estado de la copia a "en reserva" si hay una reserva.
        if (($hold = \common\models\BiblioHold::findOne(['copyid' => $copyid, 'bibid' => $bibid])) !== null) {
            $biblioCopy->status_cd = 'hld';
            Yii::$app->getSession()->setFlash('info', Yii::t('circulation', 'The bibliography with barcode number {barcode} that you are attempting to check in has one or more hold requests placed on it.  <b>Please file this bibliography with your held items instead of placing it on your shelving cart.</b>  The status code for this bibliography has been set to hold.', ['barcode' => $biblioCopy->barcode_nmbr]));
            //            return false;
        } else {
            $biblioCopy->status_cd = 'crt';
        }

        $biblioCopy->mbr_id = null;
        $biblioCopy->status_begin_dt = date('Y-m-d H:i:s', strtotime($biblioCopy->status_begin_dt) + 1);
        $biblioCopy->due_back_dt = null;
        $biblioCopy->updated_at = date('Y-m-d H:i:s');
        if (!$biblioCopy->save()) {
            array_walk_recursive($biblioCopy->errors, function ($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
            return false;
        }

        // crear el historial para el miembro
        $biblioStatusHistory = new \common\models\BiblioStatusHistory();
        $biblioStatusHistory->bibid = $bibid;
        $biblioStatusHistory->copyid = $copyid;
        $biblioStatusHistory->mbr_id = $id;
        $biblioStatusHistory->status_cd = 'crt';
        $biblioStatusHistory->created_at = date('Y-m-d H:i:s');
        // la fecha de devolución en el historial es la misma de la de la copia.
        $biblioStatusHistory->due_back_dt = null;

        if (!$biblioStatusHistory->save()) {
            array_walk_recursive($biblioStatusHistory->errors, function ($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
        }


        return true;
    }

    /**
     * Cambia el estado del material bibliográfico a disponible.
     *
     * Se evalúa si el miembro que devuelve el libro lo devuelve en una fecha posterior a la establecida,
     * genera la multa correspondiente y bloquea la cuenta del usuario para nuevos préstamos externos.
     * @param int $bibid
     * @param int $copyid
     * @param int $id
     * @return boolean
     */
    protected function checkin(int $bibid, int $copyid, int $id)
    {
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
            $trans = new \common\models\MemberAccount();
            $trans->mbr_id = $id;
            $trans->create_userid = Yii::$app->user->id;
            $trans->created_at = date('Y-m-d H:i:s');
            $trans->transaction_type_cd = "+c";
            $trans->amount = $fee * $late;
            $trans->description = Yii::t('circulation', "Late fee (barcode={n, number})", ['n' => $biblioCopy->barcode_nmbr]);
            if (!$trans->save()) {
                array_walk_recursive($trans->errors, function ($v, $k) {
                    Yii::$app->getSession()->setFlash('error', $v);
                });
                return false;
            }

            $member = $this->findModel($id);
            $member->status = Member::STATUS_BLOCKED;
            $member->save();
        }
        //return true;
    }
}
