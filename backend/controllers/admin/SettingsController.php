<?php

namespace backend\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SettingsController extends Controller {

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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
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
    public function actionLibrarySettings() {
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
                
                if($model->save()) {
                    return $this->redirect(['admin/settings']); #$this->render('library_settings', ['model' => $model]);
                }
            } else {
                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app/settings', 'Settings changed successfuly.'));
                    return $this->redirect(['admin/settings']); #$this->render('library_settings', ['model' => $model]);
                }
            }
        } else {
            array_walk_recursive($model->errors, function($v, $k) {
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
    protected function findModel() {
        if (($model = \common\models\Settings::find()->one()) !== null) {
            return $model;
        } else {
            $model = new \common\models\Settings;
            return $model;
        }
    }

}
