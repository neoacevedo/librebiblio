<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2022 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace backend\controllers\admin;

use Yii;
use common\models\Theme;
use backend\models\ThemeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * ThemeController implementa las opereaciones CRUD para el modelo Theme.
 *
 * Cada tema se instala en el directorio _themes_ de los niveles **frontend** y **backend**.<br />
 * Para entender una parte del manejo de temas, vaya a la sección de Temas de Yii (https://www.yiiframework.com/doc/guide/2.0/es/output-theming).<br />
 * La instalación se realiza desde un archivo ZIP el cual contiene la estructura del tema y un archivo **_settings.json_** con la descripcíon y configuraciones
 * básicas del tema.
 *
 * El archivo _settings.json_ tiene la siguiente estructura:
 * ```js
 * {
 *   "name": "AdminLTE",
 *   "frontend": 0,
 *   "navbar_skins": [
 *       "navbar-primary navbar-dark",
 *       "navbar-secondary navbar-dark",
 *       "navbar-info navbar-dark",
 *       "navbar-succes navbar-darks",
 *       "navbar-danger navbar-dark",
 *       "navbar-indigo navbar-dark",
 *       "navbar-purple navbar-dark",
 *       "navbar-pink navbar-dark",
 *       "navbar-navy navbar-dark",
 *       "navbar-lightblue navbar-dark",
 *       "navbar-teal navbar-dark",
 *       "navbar-cyan navbar-dark",
 *       "navbar-dark",
 *       "navbar-gray-dark navbar-dark",
 *       "navbar-gray navbar-dark",
 *       "navbar-light",
 *       "navbar-white navbar-light": 1
 *   ],
 *   "sidebar_colors": [
 *       "bg-primary": 1,
 *       "bg-warning",
 *       "bg-info",
 *       "bg-danger",
 *       "bg-success",
 **      "bg-indigo",
 *       "bg-lightblue",
 *       "bg-navy",
 *       "bg-purple",
 *       "bg-fuchsia",
 *       "bg-pink",
 *       "bg-maroon",
 *       "bg-orange",
 *       "bg-lime",
 *       "bg-teal",
 *       "bg-olive"
 *   ],
 *   "sidebar_skins": [
 *       "sidebar-dark-primary": 1,
 *       "sidebar-dark-warning",
 *       "sidebar-dark-info",
 *       "sidebar-dark-danger",
 *       "sidebar-dark-success",
 *       "sidebar-dark-indigo",
 *       "sidebar-dark-lightblue",
 *       "sidebar-dark-navy",
 *       "sidebar-dark-purple",
 *       "sidebar-dark-fuchsia",
 *       "sidebar-dark-pink",
 *       "sidebar-dark-maroon",
 *       "sidebar-dark-orange",
 *       "sidebar-dark-lime",
 *       "sidebar-dark-teal",
 *       "sidebar-dark-olive",
 *       "sidebar-light-primary",
 *       "sidebar-light-warning",
 *       "sidebar-light-info",
 *       "sidebar-light-danger",
 *       "sidebar-light-success",
 *       "sidebar-light-indigo",
 *       "sidebar-light-lightblue",
 *       "sidebar-light-navy",
 *       "sidebar-light-purple",
 *       "sidebar-light-fuchsia",
 *       "sidebar-light-pink",
 *       "sidebar-light-maroon",
 *       "sidebar-light-orange",
 *       "sidebar-light-lime",
 *       "sidebar-light-teal",
 *       "sidebar-light-olive"
 *   ]
 * }
 * ```
 *
 * La estructura de directorios del archivo comprimido del tema es la siguiente:
 *
 * - basePath (/backend | /frontend)
 * - - themes
 * - - - nombre_del_tema
 *
 * Esta estructura cambia internamente dependiendo del nivel.
 *
 * Para _backend_:
 *
 * - admin
 * - -  checkout-privs
 * - - collection
 * - - material-type
 * - - member-classify
 * - - report
 * - - <ReportType>Search
 * - biblio-copy
 * - cataloging
 * - - biblio
 * - - biblio-field
 * - circulation
 * - - placehold
 * - - checkout
 * - collectoin
 * - layouts
 * - member-account
 * - site
 *
 * Para _frontend_:
 * - biblio
 * - circulation
 * - layouts
 * - member
 * - site
 *
 * Adicional a ello, en algunos directorios se crean subdirectorios para idiomas específicos. Por ejemplo:
 *
 * - backend
 * - - AdminLTE
 * - - - site
 * - - - - es-CO
 *
 * Esto permite la traducción de contenido o texto que no está de manera nativa dentro de la aplicación (dentro de los archivos _messages/[idioma]/file.php_
 * y que no se incluyen en el archivo principal de configuración.
 *
 * **NOTA:** Si no se incluye en la estructura anterior algún archivo/directorio, es posible que la aplicación renderice una predefinida o que genere un error 400
 */
class ThemeController extends Controller
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
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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
     * Lists all Theme models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThemeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Sube el archivo zip del tema y lo instala.
     *
     * El archivo **zip** se sube al directorio _tmp_ del backend.
     * Luego lee el archivo **_JSON_** con la información del tema y procede a extraer el contenido del zip en el directorio themes
     * del frontend/backend dependiendo de la configuración del JSON.
     *
     * Posterior a ello borra el archivo zip.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Theme();
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);

        if ($model->load(Yii::$app->request->post())) {
            $model->themeFile = UploadedFile::getInstance($model, "themeFile");
            if ($model->themeFile !== null) {
                if ($model->upload()) {
                    $path = Yii::$app->runtimePath;
                    $zip = new \ZipArchive();
                    $zip->open("$path/tmp/{$model->themeFile->name}");

                    $theme = json_decode($zip->getFromName("{$model->themeFile->baseName}/settings.json"));
                    $model->frontend = $theme->frontend;
                    $model->name = $theme->name;
                    $model->active = 0;
                    $model->sourcePath = $theme->sourcePath;
                    if (isset($theme->settings)) {
                        $model->settings = json_encode($theme->settings);
                    }
                    $model->created_at = date('Y-m-d H:i:s');
                    if ($theme->frontend == 1) {
                        if ($zip->extractTo(Yii::getAlias("@frontend") . "/themes/")) {
                            $zip->close();
                        } else {
                            Yii::$app->getSession()->setFlash('error', Yii::t('app/theme', 'Could not copy theme files.'));
                        }
                    } else {
                        if ($zip->extractTo(Yii::getAlias("@backend") . "/themes/")) {
                            $zip->close();
                        } else {
                            Yii::$app->getSession()->setFlash('error', Yii::t('app/theme', 'Could not copy theme files.'));
                        }
                    }

                    if ($model->validate() && $model->save()) {
                        Yii::$app->getSession()->setFlash('success', Yii::t('app/theme', 'Theme installed successfully.'));
                    } else {
                        @array_walk_recursive($model->errors, function ($v, $k) {
                            Yii::$app->getSession()->setFlash('error', $v);
                        });
                    }

                    @unlink("$path/tmp/{$model->themeFile->name}");
                } else {
                    @array_walk_recursive($model->errors, function ($v, $k) {
                        Yii::$app->getSession()->setFlash('error', $v);
                    });
                }
            } else {
                @array_walk_recursive($model->errors, function ($v, $k) {
                    Yii::$app->getSession()->setFlash('error', $v);
                });
                $result = Yii::t('app/theme', "File not uploaded");
                Yii::$app->getSession()->setFlash('warning', $result);
            }
        } else {
            @array_walk_recursive($model->errors, function ($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });
        }
        return $this->redirect(['index']);
    }

    /**
     * Updates an existing Theme model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $tema_activo = Theme::findOne(['frontend' => $model->frontend, "active" => 1]);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        $editableIndex = $this->request->post("editableIndex");
        $post = [];
        $post["Theme"] = @$this->request->post("Theme")[$editableIndex];

        $array_settings = [];
        $json_settings = "";

        $success = false;
        $message = "";

        if ($model->frontend == 0) {
            $array_settings = json_decode($model->settings, true);
            $array_settings = array_merge($array_settings, $this->request->post("settings", ["dark-mode" => 0]));
            $json_settings = Json::encode($array_settings);
        } else {
            $array_settings = json_decode(file_get_contents(Yii::getAlias($model->sourcePath) . "/settings.json"), true);
        }

        $post["Theme"]["settings"] = $json_settings;

        if ($model->load($post) && $model->save()) {
            if ($tema_activo->id !== $model->id) {
                if ($model->active == 1) {
                    $tema_activo->active = 0;
                    if (!$tema_activo->save()) {
                        $message .= "<ul>";
                        foreach ($tema_activo->errors as $key => $error) {
                            $message .= "<li>{$error[0]}</li>";
                        }
                        $message .= "</ul>";
                    }
                }
            }
            $success = true;
        } else {
            $message .= "<ul>";
            foreach ($model->errors as $key => $error) {
                $message .= "<li>{$error[0]}</li>";
            }
            $message .= "</ul>";
            return $this->asJson(['success' => $success, "message" => $message]);
        }

        Yii::$app->session->setFlash('success', Yii::t("app/theme", "Theme updated successfully."));

        return $this->redirect(['index']);
    }

    public function actionRefresh()
    {
        $vendorDir = Yii::$app->getVendorPath();
        $settingsFile = \yii\helpers\FileHelper::findFiles($vendorDir, ['only' => ['settings.json']]);
        Yii::debug($settingsFile);
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Theme model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete(int $id)
    {
        $model = $this->findModel($id);
        $path = Yii::$app->basePath;
        $name = "default";
        if ($model->frontend == 1) {
            $path = Yii::$app->basePath . "/../frontend";
            $name = "simple";
        }
        if (is_dir("$path/themes/{$model->name}")) {
            $this->delTree("$path/themes/{$model->name}");
        }

        if (is_dir("$path/web/themes/{$model->name}")) {
            $this->delTree("$path/web/themes/{$model->name}");
        }

        if ($model->active == 1) {
            $defaultModel = Theme::find()
                ->where(['frontend' => $model->frontend, "name" => $name])
                ->one();
            $defaultModel->active = 1;
            $defaultModel->save();
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
    protected function findModel(int $id)
    {
        if (($model = Theme::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::debug($model);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Borra un directorio completo.
     * Método abstraído de ({http://php.net/manual/es/function.rmdir.php#110489}) para borrar
     * el directorio completo del tema.
     * @param string $dir
     * @access private
     * @return bool
     */
    protected function delTree(string $dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}
