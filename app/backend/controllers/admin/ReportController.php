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

namespace backend\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ReportController implementa los métodos para la visualización y descarga de reportes.
 *
 * En la vista del reporte, se puede opcionalmente descargar el reporte
 * en formato PDF, CVS y EXCEL.
 *
 * Cada reporte es un modelo que apunta a una vista de la base de datos. Adicional al modelo [[\yii\db\ActiveRecord]] (https://www.yiiframework.com/doc/api/2.0/yii-db-activerecord) conocido
 * estos tienen 2 atributos adicionales: [[\backend\reports\Acquisitions::$name|$name]] y [[\backend\reports\Acquisitions::$category|$category]].
 *
 * $name es el nombre del reporte. $category es la sección a la que pertenece el reporte.
 *
 * Para crear un reporte propio se debería primero crear una vista en la base de datos y a través de [Gii] (https://www.yiiframework.com/doc/guide/2.0/en/start-gii)
 * generar el modelo y el modelo de búsqueda que lo extienda. Ver como ejemplo el reporte de Adquisiciones ([[\backend\reports\Acquisitions|Acquisitions]]).
 */
class ReportController extends Controller
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
     * Lista todos los reportes disponibles en el sitio.
     *
     * La sección de cada reporte está determinada por el atributo {$category} del modelo.<br />
     * Para idiomas diferentes al Inglés, en algunos nombres de categorías o reportes se generarían sus respectivas traducciones
     * pero encerradas con doble arroba (@@nombre de la categoría@@), esto debido a que los reportes son dinámicos y no están
     * predefinidos.
     * @return mixed
     */
    public function actionIndex()
    {
        $directory = Yii::getAlias("@backend") . "/reports/";
        $reports = [];
        $files = \yii\helpers\FileHelper::findFiles($directory, ['only' => ['*.php'], 'except' => ['*Search.php']]);
        $report_files = str_replace("$directory", "", $files);
        foreach ($report_files as $file) {
            $classname = "backend\\reports\\" . substr($file, 0, -4);
            $report = new $classname;
            $reports[Yii::t("app/reports", $report->getCategory())][] = $report;
        }
        Yii::debug($reports);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
            'reports' => $reports,
        ]);
    }

    /**
     * Permite realizar el reporte de acuerdo a varios filtros disponibles.
     *
     * El filtro lo establece cada reporte. El modelo es invocado de acuerdo al nombre del tipo de reporte.
     * @return mixed
     */
    public function actionSearch()
    {
        $classnameSearch = "backend\\reports\\" . $this->request->get("type") . "Search";
        $searchModel = new $classnameSearch;
        $view = strtolower(Yii::$app->request->get("type"));
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render($view, [
            'model' => $searchModel,
            'materialType' => \common\models\MaterialType::find()->all(),
            'collection' => \backend\models\Collection::find()->all()
        ]);
    }

    /**
     * Muestra el reporte generado.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $classnameSearch = "backend\\reports\\" . Yii::$app->request->get("type");
        $viewName = Yii::$app->request->get("type");
        $searchModel = new $classnameSearch;
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render("$viewName/view", [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}
