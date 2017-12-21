<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php'), require(__DIR__ . '/../../common/config/i18n.php')
);

$urlManager = require(__DIR__ . '/urlManager.php');

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'db'],
    'controllerNamespace' => 'frontend\controllers',
    'on beforeRequest' => function() {
        $settings = \common\models\Settings::find()->one();
        if ($settings->offline == 1) {
            throw new \yii\web\HttpException(503, Yii::t('app', 'Maintenance Mode'));
            /* Yii::$app->catchAll = [
              // force route if portal in maintenance mode
              'site/maintenance',
              'message' => Yii::t('app', 'Maintenance Mode'),
              'status' => 503
              ]; */
        }
    },
    'on beforeAction' => function() {
        $theme = \common\models\Theme::find()->where(['active' => 1, 'frontend' => 1])->one();
        Yii::$app->getView()->theme = new \yii\base\Theme([
            'basePath' => "@app/themes/{$theme->name}",
            'baseUrl' => "@web/themes/{$theme->name}",
            'pathMap' => [
                '@app/views' => "@app/themes/{$theme->name}",
            ],
        ]);
    },
    //'language' => 'es-CO',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'nS24qNF2Yr72wN56u08P6wgfIZQsPoaC',
        ],
        'user' => [
            'identityClass' => 'common\models\Member',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'urlManager' => $urlManager,
    ],
    'params' => $params,
];
