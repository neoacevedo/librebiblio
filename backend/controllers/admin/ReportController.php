<?php

namespace backend\controllers\admin;

use Yii;
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
     * Lista todos los reportes disponibles en el sitio.
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
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
                    'objects' => $objects,
        ]);
    }

    /**
     * Permite realizar el reporte de acuerdo a varios filtros disponibles.
     * @return mixed
     */
    public function actionSearch() {
        $classnameSearch = "backend\\reports\\" . Yii::$app->request->get("type") . "Search";
        $searchModel = new $classnameSearch;
        $view = strtolower(Yii::$app->request->get("type"));
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render($view, [
                    'model' => $searchModel,
        ]);
    }

    /**
     * Displays a single Acquisitions model.
     * @param integer $id
     * @return mixed
     */
    public function actionView() {
        $classnameSearch = "backend\\reports\\" . Yii::$app->request->get("type");
        $searchModel = new $classnameSearch;
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider]);
    }

    /**
     * Renderiza en formato PDF los resultados del reporte.
     * @return mixed
     */
    public function actionPdf() {
        $report = Yii::$app->request->get("type");
        $classnameSearch = "backend\\reports\\$report";
        $searchModel = new $classnameSearch;
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(false);
        $dataProvider->setPagination(false);
        // obtener el html
        $content = $this->renderPartial('pdf', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider]);

        $pdf = Yii::$app->pdf;
        $pdf->content = $content;
        $pdf->options = ['title' => Yii::$app->name];
        $pdf->methods = [
            'SetHeader' => [date('Y-m-d H:i:s')],
            'SetFooter' => [Yii::$app->name . '||{PAGENO}'],
        ];
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionExcel() {
        $report = Yii::$app->request->get("type");
        $classnameSearch = "backend\\reports\\$report";
        $searchModel = new $classnameSearch;
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(false);
        $dataProvider->setPagination(false);
        // obtener el html
        $content = $this->renderPartial('excel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider]);

        $filename = 'Data-' . Date('YmdGis') . '-'. Yii::$app->name .".xlsx";
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=" . $filename);
        echo $content;
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

}
