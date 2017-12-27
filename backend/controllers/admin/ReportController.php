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
 * Directorio con los archivos de reporte (.rpt)
 */
define("REPORT_DEFS_DIR", Yii::$app->basePath . "/reports/");

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

    public function actionIndex() {
        $files = \yii\helpers\FileHelper::findFiles(REPORT_DEFS_DIR);
        $objects = [];
        $report_files = str_replace(Yii::getAlias("@backend")."/reports/", "", $files);
        foreach ($report_files as $file) {
            $classname = '\\backend\\reports\\'.substr($file, 0, -4); # remover la extensión
            $report = new $classname;
            $objects[$report->category][] = $report;
        }
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', ['objects' => $objects]);
    }
    
}
