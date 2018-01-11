<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

$urlManagerFrontend = require(__DIR__ . '/../../frontend/config/urlManager.php');

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'on beforeAction' => function() {
        $theme = \common\models\Theme::find()->where(['active' => 1, 'frontend' => 0])->one();
        if ($theme) {
            Yii::$app->getView()->theme = new \yii\base\Theme([
                'basePath' => "@app/themes/{$theme->name}",
                'baseUrl' => "@web/themes/{$theme->name}",
                'pathMap' => [
                    '@app/views' => "@app/themes/{$theme->name}",
                ],
            ]);
            // configurar el tema en la sesión        
            Yii::$app->session->set('backend-skin', $theme->skin);
        }
    },
    'modules' => [
        'rbac' => [
            'class' => 'johnitvn\rbacplus\Module',
            'userModelClassName' => null,
            'userModelIdField' => 'id',
            'userModelLoginField' => 'username',
            'userModelLoginFieldLabel' => null,
            'userModelExtraDataColumls' => null,
//            'userModelExtraDataColumls' => [
//                [
//                    'attributes' => 'created_at',
//                    'value' => function($model) {
//                        return date('m/d/Y', $model->created_at);
//                    }
//                ]
//            ],
            'beforeCreateController' => function ($action) {

                return Yii::$app->response->redirect(["admin/users"]);

                #throw new NotFoundHttpException('The requested page does not exist.');
            },
            'beforeAction' => function ($action) {
                /* $roles = (array) Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                  //Yii::info($roles);
                  if (array_key_exists("admin", $roles)) {
                  return true;
                  } */
                return Yii::$app->response->redirect(["admin/users"]);

                #throw new NotFoundHttpException('The requested page does not exist.');
            },
        ],
    ],
    //'language' => 'es-CO',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '9BvFtaWREW6eFhUe84XdS6CZNX3oUbSy',
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'authTimeout' => 3600
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'ob2',
            'timeout' => 3600
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'forceTranslation' => true,
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'pdf' => [
            'class' => kartik\mpdf\Pdf::classname(),
            'format' => kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => kartik\mpdf\Pdf::ORIENT_LANDSCAPE,
            'destination' => kartik\mpdf\Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
        ],
        'urlManagerFrontend' => $urlManagerFrontend,
    ],
    'params' => $params,
];
