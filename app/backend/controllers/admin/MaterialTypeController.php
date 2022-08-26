<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace backend\controllers\admin;

use Yii;
use common\models\MaterialType;
use backend\models\MaterialTypeSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MaterialTypeController implements the CRUD actions for MaterialType model.
 */
class MaterialTypeController extends Controller
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
                        //'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin'],
                        /*'matchCallback' => function () {
                            $roles = (array) Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                            //Yii::info($roles);
                            if (array_key_exists("admin", $roles)) {
                                return true;
                            }
                            return false;
                        },*/
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
     * Lists all MaterialType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaterialTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaterialType model.
     * @param integer $id
     * @return mixed
     */
    public function actionView(int $id)
    {
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MaterialType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MaterialType();
        // Uploaded file instance.
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);

        $material_type_list = [
            "" => "--",
            'bi bi-disc' => "CD",
            "bi bi-cassete" => Yii::t("app/settings", "Audio Tapes"),
            "bi bi-book" => Yii::t("app/settings", "Books"),
            "bi bi-pc" => Yii::t("app/settings", "Equipment"),
            "bi bi-journal" => Yii::t("app/settings", "Magazines"),
            "bi bi-newspaper" => Yii::t("app/settings", "Newspaper"),
            "bi bi-map" => Yii::t("app/settings", "Maps"),
        ];

        $fileModel = Yii::$app->storage->getFileManager();

        if ($model->load(Yii::$app->request->post())) {
            if (null !== $fileModel->uploadedFile) {
                if (Yii::$app->storage->save($fileModel)) {
                    $model->image_file = Yii::$app->storage->getUrl($fileModel->uploadedFile->name);
                } else {
                    $message = "<ul>";
                    foreach ($fileModel->errors as $key => $error) {
                        $message .= "<li>{$error[0]}</li>";
                    }
                    $message .= "</ul>";

                    Yii::$app->session->setFlash('error', $message);
                }
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t("app/settings", "Material Type created/updated successfully."));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $message = "<ul>";
                foreach ($model->errors as $key => $error) {
                    $message .= "<li>{$error[0]}</li>";
                }
                $message .= "</ul>";

                Yii::$app->session->setFlash('error', $message);
            }
        }

        return $this->render('create', [
            'model' => $model,
            "material_type_list" => $material_type_list,
            'fileModel' => $fileModel
        ]);
    }

    /**
     * Updates an existing MaterialType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $material_type_list = [
            "" => "--",
            'bi bi-disc' => "CD",
            "bi bi-cassete" => Yii::t("app/settings", "Audio Tapes"),
            "bi bi-book" => Yii::t("app/settings", "Books"),
            "bi bi-pc" => Yii::t("app/settings", "Equipment"),
            "bi bi-journal" => Yii::t("app/settings", "Magazines"),
            "bi bi-newspaper" => Yii::t("app/settings", "Newspaper"),
            "bi bi-map" => Yii::t("app/settings", "Maps"),
        ];

        // Uploaded file instance.
        $fileModel = Yii::$app->storage->getFileManager();

        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if ($model->load(Yii::$app->request->post())) {
            if (null !== $fileModel->uploadedFile) {
                if (Yii::$app->storage->save($fileModel)) {
                    $model->image_file = Yii::$app->storage->getUrl($fileModel->uploadedFile->name);
                } else {
                    $message = "<ul>";
                    foreach ($fileModel->errors as $key => $error) {
                        $message .= "<li>{$error[0]}</li>";
                    }
                    $message .= "</ul>";

                    Yii::$app->session->setFlash('error', $message);
                }
            } else {
                if ($model->icon != "") {
                    $model->image_file = "";
                }
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t("app/settings", "Material Type created/updated successfully."));
                return $this->redirect(['index']);
            } else {
                $message = "<ul>";
                foreach ($model->errors as $key => $error) {
                    $message .= "<li>{$error[0]}</li>";
                }
                $message .= "</ul>";

                Yii::$app->session->setFlash('error', $message);
            }
        }

        return $this->render('update', [
            'model' => $model,
            "material_type_list" => $material_type_list,
            'fileModel' => $fileModel
        ]);
    }

    /**
     * Deletes an existing MaterialType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete(int $id)
    {
        Yii::$app->storage->delete($this->findModel($id)->image_file);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MaterialType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaterialType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        if (($model = MaterialType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
