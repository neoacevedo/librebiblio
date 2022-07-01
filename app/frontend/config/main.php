<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php'),
    require(__DIR__ . '/../../common/config/i18n.php')
);

$urlManager = require(__DIR__ . '/urlManager.php');

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'db'],
    'controllerNamespace' => 'frontend\controllers',
    'on beforeAction' => function () {
        $theme = \common\models\Theme::find()->where(['active' => 1, 'frontend' => 1])->one();
        if ($theme) {
            Yii::$app->getView()->theme = new \yii\base\Theme([
                'basePath' => "@app/themes/{$theme->name}",
                'baseUrl' => "@web/themes/{$theme->name}",
                'pathMap' => [
                    '@app/views' => "@app/themes/{$theme->name}",
                ],
            ]);
            // configurar el tema en la sesión
            Yii::$app->session->set('frontend-skin', $theme->skin);
        }
    },
    //'language' => 'es-CO',
    'catchAll' => [
        $params['offline'] == 1 ? 'site/offline': ''
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\Member',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'lb-front',
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
