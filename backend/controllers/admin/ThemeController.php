<?php

namespace backend\controllers\admin;

use Yii;
use common\models\Theme;
use backend\models\ThemeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ThemeController implements the CRUD actions for Theme model.
 */
class ThemeController extends Controller {

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
                        //'actions' => ['users', 'users-update', 'users-delete', 'users-view', 'settings', 'themes'],
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Theme models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ThemeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Theme model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Theme model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Theme();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                        'model' => $model,
            ]);
        }
        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {
            $model->themeFile = UploadedFile::getInstanceByName('themeFile');
            if ($model->themeFile !== null) {
                if ($model->upload()) {
                    $path = Yii::$app->basePath;
                    $zip = new \ZipArchive();
                    $zip->open("$path/tmp/{$model->themeFile->name}");
                    $name = $zip->getNameIndex(2);
                    $theme = json_decode($zip->getFromName("{$name}settings.json"));
                    $model->frontend = $theme->frontend;
                    $model->name = $theme->name;
                    $model->active = 0;
                    $model->created_at = date('Y-m-d H:i:s');
                    if ($zip->extractTo("$path/../")) {
                        $zip->close();
                        unlink("$path/tmp/{$model->themeFile->name}");
                    } else {
                        Yii::$app->getSession()->setFlash('error', Yii::t('app/theme', 'Could not copy theme files.'));
                    }

                    if ($model->validate() && $model->save()) {
                        Yii::$app->getSession()->setFlash('success', Yii::t('app/theme', 'Theme installed successfully.'));
                    } else {
                        array_walk_recursive($model->errors, function($v, $k) {
                            Yii::$app->getSession()->setFlash('error', $v);
                        });
                    }

                    return $this->redirect(['index']);
                }
            } else {
                $result = "No se subió archivo";
            }
            Yii::$app->getSession()->setFlash('warning', $result);
            return $this->redirect(['index']);
        } else {
            array_walk_recursive($model->errors, function($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an existing Theme model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Theme model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $path = Yii::$app->basePath;
        if ($model->frontend == 1) {
            $path = Yii::$app->basePath . "/../frontend";
        }
        if (is_dir("$path/themes/{$model->name}")) {
            $this->delTree("$path/themes/{$model->name}");
        }

        if (is_dir("$path/web/themes/{$model->name}")) {
            $this->delTree("$path/web/themes/{$model->name}");
        }

        $model->delete();
        Yii::$app->getSession()->setFlash('success', Yii::t("app/theme", "Theme uninstalled successfully."));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Theme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Theme the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Theme::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

}
