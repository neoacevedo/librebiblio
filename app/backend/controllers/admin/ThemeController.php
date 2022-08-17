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
 * La instalación se realiza desde un archivo ZIP el cual contiene la estructura del tema y un archivo **_theme.json_** con la descripcíon y configuraciones
 * básicas del tema.
 *
 * El archivo _theme.json_ tiene la siguiente estructura:
 * ```js
 * {
 *   "name": "Nombre del tema",
 *   "frontend": 0,
 *   "sourcePath": "@app/themes/Tema",
 *   "settings": {
 *        "option0": 0
 *   }
 * }
 * ```
 * La sección `settings` es opcional y se usa para que cada usuario pueda personalizar las configuraciones del tema para su sesión,
 * además de simplemente permitir renderizar los campos de un formulario para personalizar la apariencia del tema, pero no se guardarán
 * los ajustes que haga cada usuario. Estos ajustes se guardan en la sesión del navegador del usuario.
 * Si el usuario borra los datos del navegador, borra los ajustes para el tema.
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
 * - - - - es
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

                    $theme = json_decode($zip->getFromName("{$model->themeFile->baseName}/theme.json"));
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

        $success = false;
        $message = "";

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

    /**
     *
     */
    public function actionRefresh()
    {
        $vendorDir = Yii::$app->getVendorPath();
        $settingsFile = \yii\helpers\FileHelper::findFiles($vendorDir, ['only' => ['theme.json']]);

        foreach ($settingsFile as $settings) {
            $model = new Theme();
            $theme = json_decode(file_get_contents($settings));
            $model->frontend = $theme->frontend;
            $model->name = $theme->name;
            $model->active = 0;
            $model->sourcePath = $theme->sourcePath;
            if (isset($theme->settings)) {
                $model->settings = json_encode($theme->settings);
            }
            $model->created_at = date('Y-m-d H:i:s');

            if ($model->validate() && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app/theme', 'Theme installed successfully.'));
            } else {
                @array_walk_recursive($model->errors, function ($v, $k) {
                    Yii::$app->getSession()->setFlash('error', $v);
                });
            }
        }

        $searchModel = new ThemeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
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
