<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace backend\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

/**
 * SettingsController implementa las configuraciones del sitio usando el modelo Settings.
 * 
 * Las configuraciones que usa son las siguientes:
 * - Nombre de la biblioteca
 * - URL de la imagen de la biblioteca (El logo empleado para el frontend (o backend, dependiendo del tema).
 * - Solo mostrar la imagen en el encabezado (Si solo se usa el logo y no logo y texto)
 * - Horario de la biblioteca
 * - Teléfono de la biblioteca
 * - Purgar historial despues de estos meses
 * - Bloquear préstamos cuando haya pendiente una multa
 * - Días máximos de reserva
 * - Artículos por página
 * - Desconectado (La biblioteca para los miembros no estará disponible cuando esta opción esté activa)
 */
class SettingsController extends Controller
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionLibrarySettings()
    {
        $model = $this->findModel();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        $files = \yii\helpers\FileHelper::findFiles("../../frontend/web/images/logo/", ['only' => ['*.png', '*.jpg', '*.jpeg']]);
        $files_list = [];
        foreach ($files as $file) {
            $file_name = substr($file, strrpos($file, "/") + 1);
            $files_list[$file_name] = $file_name;
        }
        // primer elemento en el array
        array_unshift($files_list, Yii::t('app', 'Choose an option'));
        // último elemento en el array
        array_push($files_list, Yii::t('app', 'Upload File:'));
        return $this->render('library_settings', ['model' => $model, 'files' => $files_list]);
    }

    /**
     * Actualiza la configuración básica de la biblioteca.
     * @return mixed
     */
    public function actionLibrarySettingsUpdate()
    {
        $model = $this->findModel();
        \Yii::$app->language = \Yii::$app->request->getPreferredLanguage(Yii::$app->params['preferredLanguages']);
        $files = \yii\helpers\FileHelper::findFiles("../../frontend/web/images/logo/", ['only' => ['*.png', '*.jpg', '*.jpeg']]);
        $files_list = [];
        foreach ($files as $file) {
            $file_name = substr($file, strrpos($file, "/") + 1);
            $files_list[$file_name] = $file_name;
        }
        // primer elemento en el array
        array_unshift($files_list, Yii::t('app', 'Choose an option'));
        // último elemento en el array
        array_push($files_list, Yii::t('app', 'Upload File:'));
        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstanceByName('imageFile');
            if ($model->imageFile) {
                if ($model->upload()) {
                    $model->library_image_url = $model->imageFile->name;
                }

                if ($model->save()) {
                    return $this->redirect(['admin/settings']); #$this->render('library_settings', ['model' => $model]);
                }
            } else {
                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app/settings', 'Settings changed successfuly.'));
                    return $this->redirect(['admin/settings']); #$this->render('library_settings', ['model' => $model]);
                }
            }
        } else {
            array_walk_recursive($model->errors, function ($v, $k) {
                Yii::$app->getSession()->setFlash('error', $v);
            });

            return $this->render('library_settings', ['model' => $model, 'files' => $files_list]);
        }
    }

    /**
     * Finds the Settings model.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return Settings the loaded model
     */
    protected function findModel()
    {
        if (($model = \common\models\Settings::find()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
