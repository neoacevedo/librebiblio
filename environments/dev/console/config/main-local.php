<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params-local.php'),
        require(__DIR__.'/params-local.php'),
        require(__DIR__.'/../../common/config/database-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
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
                'host' => '%%SMTP_HOST%%', // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => '%%SMTP_USERNAME%%',
                'password' => '%%SMTP_PASSWORD%%',
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
            'baseUrl' => '%%BASEURL%%', // reemplazar de manera manual por el dominio para el backend
            'scriptUrl' => "%%SCRIPTURL%%",
            'enablePrettyUrl' => false,
            'rules' => [
            ],
        ],
    ],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'params' => $params,
];

