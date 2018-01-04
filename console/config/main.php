<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/params-local.php')
);

$db = require(__DIR__ . "/database.php");
return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
    ],
    'components' => [
        'db' => $db,
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false, //for the testing purpose, you need to enable this
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.googlemail.com', // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'nestor.acevedo.romero@gmail.com',
                'password' => "Hynt1b@2017",
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'logFile' => '@runtime/logs/app.log',
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => (filter_input(INPUT_SERVER, 'SERVER_NAME') === 'localhost') ? 'http://localhost/openbiblio2/backend/web': filter_input(INPUT_SERVER, 'SERVER_NAME'), // reemplazar de manera manual por el dominio para el backend
            'scriptUrl' => (filter_input(INPUT_SERVER, 'SERVER_NAME') === 'localhost') ? 'http://localhost/openbiblio2/backend/web': filter_input(INPUT_SERVER, 'SERVER_NAME'), // reemplazar de manera manual por el dominio para el backend
            'enablePrettyUrl' => false,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
