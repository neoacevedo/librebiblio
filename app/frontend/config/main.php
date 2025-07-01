<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$urlManager = require __DIR__ . '/urlManager.php';

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'catchAll' => $catchAll,
    'components' => [
        'view' => [
            'theme' => [
                'class' => 'frontend\components\Theme'
            ],
        ],
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
            'class' => 'yii\web\Session',
            'cookieParams' => ['httponly' => true],
            'useCookies' => true
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'exportInterval' => YII_DEBUG ? 1 : 10,
                    'levels' => YII_DEBUG ? ['error', 'warning', 'info', 'trace'] : ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => $urlManager,
    ],
    'params' => $params,
];
