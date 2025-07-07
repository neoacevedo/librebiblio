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
use common\models\MemberAccount;
use common\models\MemberAccountSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MemberAccountController implements the CRUD actions for MemberAccount model.
 */
class MemberAccountController extends Controller
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
     * Lists all MemberAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemberAccountSearch();
        $searchModel->mbr_id = Yii::$app->request->get('mbr_id');
        $dataProvider = $searchModel->search([]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MemberAccount model.
     * @param integer $id
     * @param integer $mbr_id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id, int $mbr_id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id, $mbr_id),
        ]);
    }

    /**
     * Creates a new MemberAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MemberAccount();
        $transactionType = \common\models\TransactionType::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'mbr_id' => $model->mbr_id]);
        } else {
            @array_walk_recursive($model->errors, function ($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
            return $this->renderAjax('create', [
                'model' => $model,
                'transactionType' => $transactionType
            ]);
        }
    }

    /**
     * Updates an existing MemberAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $mbr_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id, int $mbr_id)
    {
        $model = $this->findModel($id, $mbr_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'mbr_id' => $model->mbr_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MemberAccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $mbr_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id, int $mbr_id)
    {
        $this->findModel($id, $mbr_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MemberAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $mbr_id
     * @return MemberAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id, int $mbr_id)
    {
        if (($model = MemberAccount::findOne(['id' => $id, 'mbr_id' => $mbr_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('circulation', 'The requested page does not exist.'));
    }
}
