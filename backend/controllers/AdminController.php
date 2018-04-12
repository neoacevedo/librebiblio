<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AdminController implements the CRUD actions for User model.
 */
class AdminController extends Controller {

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
                        'actions' => ['users', 'users-create', 'users-update', 'users-delete', 'users-view', 'settings', 'themes'],
                        'allow' => true,
                        'roles' => ['admin'],
                    //'controllers' => [AdminController::className(), admin\SettingsController::className()],
                    /* 'matchCallback' => function () {
                      $roles = (array) Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                      //Yii::info($roles);
                      if (array_key_exists("admin", $roles)) {
                      return true;
                      }

                      return false;
                      }, */
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
     * Lists all User models.
     * @return mixed
     */
    public function actionUsers() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('users/index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionUsersView(int $id) {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('users/view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUsersCreate() {
        $model = new \backend\models\SignupForm();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'User registered'));
                return $this->redirect(['admin/users-view', 'id' => $user->id]);
            } else {
                @array_walk_recursive($model->errors, function($v, $k) {
                            Yii::$app->getSession()->setFlash('error', $v);
                        });
                return $this->render('users/create', [
                            'model' => $model,
                ]);
            }
        } else {
            @array_walk_recursive($model->errors, function($v, $k) {
                        Yii::$app->getSession()->setFlash('error', $v);
                    });
            return $this->render('users/create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUsersUpdate(int $id) {
        $model = $this->findModel($id);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['admin/users-view', 'id' => $model->id]);
        } else {
            @array_walk_recursive($model->errors, function($v, $k) {
                        Yii::$app->getSession()->setFlash('error', $v);
                    });
            return $this->render('users/update', [
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
    public function actionUsersDelete(int $id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSettings() {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('settings/index');
    }

    public function actionLibrarySettings() {
        $model = $this->findSettingsModel();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('settings/library_settings', ['model' => $model]);
        } else {
            @array_walk_recursive($model->errors, function($v, $k) {
                        Yii::$app->getSession()->setFlash('error', $v);
                    });

            return $this->render('settings/library_settings', ['model' => $model]);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id) {
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    private function findSettingsModel() {
        if (($model = \common\models\Settings::find()->one()) !== null) {
            return $model;
        } else {
            $model = new \common\models\Settings;
            return $model;
        }
    }

}
