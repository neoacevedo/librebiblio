<?php

namespace backend\controllers;

use backend\models\User;
use backend\models\UserSearch;
use console\models\PasswordResetRequest;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['login', 'error'],
                            'allow' => true,
                        ],
                        [
                            'actions' => ['index', 'flush-cache', 'create','update', 'delete', 'view'],
                            'allow' => true,
                            'roles' => ['admin'],
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
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load($this->request->post())) {
            $model->generateAuthKey();
            $model->generateEmailVerificationToken();
            $model->setPassword(time());
            if ($model->save()) {
                $passwordResetRequest = new PasswordResetRequest();
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
                Yii::$app->session->setFlash('success', Yii::t("app", "User registered successfully."));
                return $this->redirect(['index']);
            } else {
                $message = "<ul>";
                foreach ($model->errors as $error) {
                    $message .= "<li>{$error[0]}</li>";
                }
                $message .= "</ul>";
                Yii::$app->session->setFlash('error', $message);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $editableIndex = Yii::$app->request->post("editableIndex");
        $post = [];
        $post["User"] = Yii::$app->request->post("User")[$editableIndex];

        if ($model->load($post) && $model->validate()) {
            if ($model->save()) {
                return $this->asJson(['success' => true]);
            } else {
                $message = "<ul>";
                foreach ($model->errors as $key => $error) {
                    $message .= "<li>{$error[0]}</li>";
                }
                $message .= "</ul>";
                return $this->asJson(['success' => false, "message" => $message]);
            }
        } else {
            $message = "<ul>";
            foreach ($model->errors as $key => $error) {
                $message .= "<li>{$error[0]}</li>";
            }
            $message .= "</ul>";
            return $this->asJson(['success' => false, "message" => $message]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
