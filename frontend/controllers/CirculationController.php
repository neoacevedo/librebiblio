<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace frontend\controllers;

use Yii;
use DateTime;
use common\models\Member;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\BiblioSearch;

/**
 * CirculationController implementa la lógica para los préstamos y reservas de materiales bibliográficos.
 * 
 * Incluye el listado del carrito con los materiales que se pretenden solicitar en préstamo.
 */
class CirculationController extends Controller 
{
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
                            if ($action->id === "placehold" || $action->id === 'checkout-cart' || $action->id === 'checkout') {
                                $model = $this->findModel(Yii::$app->user->id);
                                if ($model->status == $model::STATUS_BLOCKED) {
                                    \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
                                    throw new ForbiddenHttpException(Yii::t('circulation', 'This member is currently blocked.'));
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
     * Agrega el item al carro.
     * 
     * El ítem es la copia del material bibliográfico. El manejo del carro se hace por sesión.
     * @param int $copyid el ID de la copia
     * @param int $bibid el ID del material bibliográfico
     * @param string $status Acepta los siguiente estados:
     * <ul>
     *  <li>hld</li>
     *  <li>out</li>
     * </ul>
     * @return mixed
     */
    public function actionAddToCart(int $copyid, int $bibid, string $status) {

        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        // agregar al carro (en sesión)
        try {
            if (!isset(\Yii::$app->session['cart'])) {
                \Yii::$app->session->set('cart', []);
            }
            $copies = array_column(\Yii::$app->session['cart'], "copyid");
            if (!in_array($copyid, $copies)) {
                $count = count(Yii::$app->session->get('cart')) + 1;
                \Yii::$app->session['cart'] = array_merge(\Yii::$app->session['cart'], [$count => ['copyid' => $copyid, 'bibid' => $bibid, 'status' => $status]]);
                Yii::$app->getSession()->setFlash('success', Yii::t('circulation', "Item added to cart."));
            } else {
                Yii::$app->getSession()->setFlash('warning', Yii::t("circulation", "The item is already on cart"));
            }
        } catch (Exception $ex) {
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Muestra el listado con los materiales bibliográficos para solicitar en préstamo.
     * 
     * El listado de los materiales se obtiene desde variables de sesión, por lo que al cerrar la sesión 
     * e iniciar de nuevo sesión, el listado desaparece.
     * 
     * @return mixed
     */
    public function actionCart() {
        $id = Yii::$app->user->id;
        if (!isset(\Yii::$app->session['cart'])) {
            \Yii::$app->session->set('cart', []);
        }
        $model = \common\models\Member::findOne($id);
        $copies = array_column(\Yii::$app->session['cart'], "copyid");
        $models = \common\models\BiblioCopy::find()->where(['in', 'id', $copies])->all();
        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => $models,
            'sort' => [
                'attributes' => ['id', 'username', 'email'],
            ],
        ]);
        return $this->render('cart', ['model' => $model, 'id' => $id, 'dataProvider' => $provider]);
    }

    /**
     * Crea una reserva de un material bibliográfico.
     * @todo Queda pendiente que el propio miembro pueda solicitar en préstamo un material.
     * @param int $bibid
     * @param int $copyid
     * @return mixed
     */
    public function actionPlacehold(int $bibid, int $copyid) {
        $id = Yii::$app->user->id;
        $this->updateMemberAccount($id);

        $memberDebt = \common\models\MemberAccount::find()->where(['mbr_id' => $id, "transaction_type_cd" => "+c"])->sum('amount');
        if ($memberDebt > 0) {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Note: Member has an outstanding account balance of {0, number, currency}", $memberDebt));
            // validar si no se permite que al usuario se le preste bibliografía si tiene deuda
            if (\common\models\Settings::find()->one()->block_checkouts_when_fines_due == 'Y') {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        //$due_back = 7 * 24 * 60 * 60; // Esto será configurable. Determinará el tiempo de devolución
        $biblioCopy = \common\models\BiblioCopy::findOne(["id" => $copyid, "bibid" => $bibid]);

        if ($biblioCopy->status_cd !== "out" && $biblioCopy->status_cd !== "hld") {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "This item is not checked out or on hold."));
            return $this->redirect(Yii::$app->request->referrer);
        }

        if ($biblioCopy->status_cd === 'out' && $biblioCopy->mbr_id === $id) {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "This member already has that item checked out -- not placing hold."));
            return $this->redirect(Yii::$app->request->referrer);
        }

        if (null !== \common\models\BiblioHold::findOne(['copyid' => $copyid, 'bibid' => $bibid, 'mbr_id' => $id])) {
            // si el miembro ya ha reservado el material, se devuelve un aviso y no se reserva de nuevo el material.
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
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
                \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
                Yii::$app->getSession()->setFlash('success', Yii::t('circulation', "Item placed hold."));
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Solicita el préstamo de las copias bibliográficas seleccionadas.
     * 
     * El método tiene una iteración interna por cada copia bibliográfica seleccionada. <br />
     * Después de esto actualiza la lista de las copias en el carrito.
     * @return mixed
     */
    public function actionCheckout() {
        $id = Yii::$app->user->id;
        // array temporal para guardar los id del array del carro seleccionado (los de la sesión).
        $copy_array = [];
        // los checkbox seleccionados
        $selection = \Yii::$app->request->post('selection'); 

        $this->updateMemberAccount($id);
                
        $memberDebt = \common\models\MemberAccount::find()->where(['mbr_id' => $id, "transaction_type_cd" => "+c"])->sum('amount');
        if ($memberDebt > 0) {
            \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
            Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Note: Member has an outstanding account balance of {0, number, currency}", $memberDebt));
            // validar si no se permite que al usuario se le preste bibliografía si tiene deuda
            if (\common\models\Settings::find()->one()->block_checkouts_when_fines_due == 'Y') {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        //$due_back = 7 * 24 * 60 * 60; // Esto será configurable. Determinará el tiempo de devolución
        foreach ($selection as $copyid) {
            $biblioCopy = \common\models\BiblioCopy::findOne($copyid);
            $collection = \backend\models\Collection::findOne(\common\models\Biblio::findOne($biblioCopy->bibid)->collection_cd);

            if ($biblioCopy->status_cd === 'hld') {
                if (($hold = \common\models\BiblioHold::findOne(['copyid' => $copyid, 'bibid' => $biblioCopy->bibid, 'mbr_id' => $id])) !== null) {
                    // el miembro fue quien reservó el material
                    $holdMaxDays = \common\models\Settings::find()->one()->hold_max_days;
                    $datetime1 = new DateTime($hold->hold_begin_dt);
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
                    }
                } else {
                    // si otro miembro reservó antes el material
                    Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Item {n, number} is on hold to another member.", ['n' => $biblioCopy->barcode_nmbr]));
                }
            }

            if ($biblioCopy->status_cd === 'out' && $biblioCopy->mbr_id === $id) {

                // el miembro tiene el material. Buscar si ya alcanzó el límite de renovaciones.
                if ($biblioCopy->hasReachedRenewalLimit(Member::findOne($id)->classification_id)) {
                    // el miembro ya alcanzó el límite de renovaciones
                    Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Item {n, number} has reached its renewal limit.", ['n' => $biblioCopy->barcode_nmbr]));
                }

                if ($biblioCopy->due_back_dt < date('Y-m-d', strtotime('now'))) {
                    // el material no ha sido devuelto en el tiempo establecido.
                    Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Item {n, number} is late and cannot be renewed.", ['n' => $biblioCopy->barcode_nmbr]));
                }
                $biblioCopy->renewal_count = $biblioCopy->renewal_count + 1;
                $biblioCopy->updated_at = date('Y-m-d H:i:s');
                // la fecha de devolución se amplía basado en la fecha de devolución inicial.
                $biblioCopy->due_back_dt = date('Y-m-d H:i:s', strtotime($biblioCopy->due_back_dt) + $collection->days_due_back);
            } elseif ($biblioCopy->status_cd === 'out' && $biblioCopy->mbr_id !== $id) {
                // si otro miembro tiene el material
                Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Item {n, number} is already checked out to another member.", ['n' => $biblioCopy->barcode_nmbr]));
            } elseif ($biblioCopy->status_cd === 'in') {
                // nadie tiene el material. Se puede prestar.
                $biblioCopy->status_begin_dt = date('Y-m-d H:i:s');
                $biblioCopy->due_back_dt = date('Y-m-d H:i:s', strtotime("now +{$collection->days_due_back} days"));
            }

            // verificar si el miembro ya alcanzó el límite de pŕestamos.
            if ($biblioCopy->hasReachedCheckoutLimit($id, Member::findOne($id)->classification_id)) {
                Yii::$app->getSession()->setFlash('warning', Yii::t('circulation', "Member has reached checkout limit for this collection."));
                return $this->redirect('member/profile');
            }

            $biblioCopy->mbr_id = $id;
            $biblioCopy->status_cd = 'out';
            $biblioCopy->updated_at = date('Y-m-d H:i:s');
            if (!$biblioCopy->save()) {
                @array_walk_recursive($biblioCopy->errors, function($v, $k) {
                            Yii::$app->getSession()->setFlash('error', $v);
                        });
            } else {
                // crear el historial para el miembro
                $biblioStatusHistory = new \common\models\BiblioStatusHistory;
                $biblioStatusHistory->bibid = $biblioCopy->bibid;
                $biblioStatusHistory->copyid = $copyid;
                $biblioStatusHistory->mbr_id = $id;
                $biblioStatusHistory->status_cd = 'out';
                $biblioStatusHistory->created_at = date('Y-m-d H:i:s');
                $biblioStatusHistory->due_back_dt = date('Y-m-d');

                if (!$biblioStatusHistory->save()) {
                    @array_walk_recursive($biblioStatusHistory->errors, function($v, $k) {
                                Yii::$app->getSession()->setFlash('error', $v);
                            });
                } else {
                    \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
                    Yii::$app->getSession()->setFlash('success', Yii::t('circulation', "Item {barcode} checked out.", ['barcode' => $biblioCopy->barcode_nmbr]));
                    $copies = array_column(\Yii::$app->session['cart'], "copyid");
                    $key = array_search((int) $copyid, $copies, true);
                    $copy_array[$key] = \Yii::$app->session['cart'][$key];
                }
            }
        }
        
        // enviar correo.
        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'memberCheckouts-html', 'text' => 'memberCheckouts-text'],
                ['member' => $this->findModel($id), 'copies' => $copy_array]
            )
            ->setFrom([Yii::$app->params['adminEmail'] => \common\models\Settings::find()->one()->library_name])
            ->setTo(Yii::$app->params['supportEmail'])
            ->setSubject('New Member Checkout')
            ->send();
        
        foreach ($copy_array as $key => $value) {
            unset($_SESSION['cart'][$key]);
        }
        return $this->redirect(['/member/profile']);
    }

    /**
     * Borra una reserva de un usuario dado.
     * Cuando borra la reserva, el material pasa al carrito.
     * @param int $id
     * @param int $mbr_id
     * @return mixed
     */
    public function actionHoldDelete(int $hld_id) {
        $biblioHold = \common\models\BiblioHold::findOne($hld_id);
        $biblioCopy = \common\models\BiblioCopy::findOne(['bibid' => $biblioHold->bibid, 'id' => $biblioHold->copyid]);
        $biblioHold->delete();
        $biblioCopy->status_cd = "crt";
        if ($biblioCopy->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('circulation', "Item placed hold."));
        } else {
            @array_walk_recursive($biblioCopy->errors, function($v, $k) {
                        Yii::$app->getSession()->setFlash('error', $v);
                    });
        }
        return $this->redirect(['member/profile']);
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

    /**
     * Actualiza la deuda del usuario.
     * 
     * @param int $mbrid
     */
    protected function updateMemberAccount() {
        $id = Yii::$app->user->id;
        $late = $fee = 0; // se definen estas dos variables de tipo entero

        $biblioCopies = \common\models\BiblioCopy::find()->where(['mbr_id' => $id])->all();

        foreach ($biblioCopies as $biblioCopy) {

            $biblio = \common\models\Biblio::findOne($biblioCopy->bibid);
            // encontrar el cargo por día de retraso
            $fee = $biblio->getCollection()->one()->daily_late_fee;
            $dueBack = strtotime($biblioCopy->due_back_dt);

            if (null !== $biblioCopy->due_back_dt) {
                if (false !== $dueBack && $dueBack !== -1) {
                    $dt = new DateTime($biblioCopy->due_back_dt);
                    $now = new DateTime("now");
                    $dtdiff = $dt->diff($now, false);
                    $late = (int) $dtdiff->format('%r%a');
                }
            }

            if ($id != "" and $late > 0 and $fee > 0) {
                $trans = new \common\models\MemberAccount;
                $trans->mbr_id = $id;
                $trans->create_userid = Yii::$app->user->id;
                $trans->created_at = date('Y-m-d H:i:s');
                $trans->transaction_type_cd = "+c";
                $trans->amount = $fee * $late;
                \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
                $trans->description = Yii::t('circulation', "Late fee (barcode={n, number})", ['n' => $biblioCopy->barcode_nmbr]);
                if (!$trans->save()) {
                    array_walk_recursive($trans->errors, function($v, $k) {
                        Yii::$app->getSession()->setFlash('error', $v);
                    });
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    $member = $this->findModel($id);
                    $member->status = Member::STATUS_BLOCKED;
                    $member->save();
                }
            }
        }
    }

}
