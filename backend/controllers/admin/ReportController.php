<?php

namespace backend\controllers\admin;

use Yii;
use backend\models\Collection;
use backend\models\CollectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ReportController implements the CRUD actions for Acquisitions model.
 */
class ReportController extends Controller {

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
                        //'actions' => ['users'],
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Acquisitions models.
     * @return mixed
     */
    public function actionIndex() {
        $directory = Yii::getAlias("@backend") . "/reports/";
        $objects = [];
        $files = \yii\helpers\FileHelper::findFiles($directory, ['only' => ['*.php'], 'except' => ['*Search.php']]);
        $report_files = str_replace("$directory", "", $files);
        foreach ($report_files as $file) {
            $classname = "backend\\reports\\" . substr($file, 0, -4);
            $object = new $classname;
            $objects[$object->category][] = $object;
        }
        return $this->render('index', [
                    'objects' => $objects,
        ]);
    }

    public function actionSearch() {
        $classnameSearch = "backend\\reports\\" . Yii::$app->request->get("type") . "Search";
        $searchModel = new $classnameSearch;
        $view = strtolower(Yii::$app->request->get("type"));
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render($view, [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionResults() {
        $classnameSearch = "backend\\reports\\" . Yii::$app->request->get("type");
        $searchModel = new $classnameSearch;
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('results', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider]);
    }

    /**
     * Displays a single Acquisitions model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Acquisitions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Acquisitions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Acquisitions model.
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
     * Deletes an existing Acquisitions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Acquisitions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Acquisitions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($model) {
        $classname = "backend\\reports\\$model";
        if (($model = $classname::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
