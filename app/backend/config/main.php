<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        // 'rbac' => [
        //     'class' => 'neoacevedo\rbacplus\Module',
        //     'userModelClassName' => null,
        //     'userModelIdField' => 'id',
        //     'userModelLoginField' => 'username',
        //     'userModelLoginFieldLabel' => null,
        //     'userModelExtraDataColumls' => null,
        //     //            'userModelExtraDataColumls' => [
        //     //                [
        //     //                    'attributes' => 'created_at',
        //     //                    'value' => function($model) {
        //     //                        return date('m/d/Y', $model->created_at);
        //     //                    }
        //     //                ]
        //     //            ],
        // ],
    ],
    'components' => [
        'view' => [
            'theme' => [
                'class' => 'backend\components\Theme',
            ]
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'lb-back',
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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
