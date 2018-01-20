<?php

$cache = require(__DIR__ . '/cache.php');
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'America/Bogota',
    'components' => [
        'cache' => $cache,
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "mysql:host=localhost;dbname=openbiblio2",
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableQueryCache' => true
        ],
        'session' => [
            'class' => 'yii\web\CacheSession',
            'cache' => 'cache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        //'defaultRoles' => ['admin', 'staff', 'user'],
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
                'rbac*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'rbac' => 'rbac.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'library*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'library' => 'library.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'circulation*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'circulation' => 'circulation.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'checkout*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'checkout' => 'checkout.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
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
    ],
    'name' => call_user_func(function() {
                $db = [
                    'dsn' => "mysql:host=localhost;dbname=openbiblio2",
                    'username' => 'root',
                    'password' => '',
                    'charset' => 'utf8',
                    'enableQueryCache' => true
                ];
                $connection = new \yii\db\Connection($db);
                $connection->open();
                try {
                    $library_name = $connection->createCommand("Select library_name from {{%settings}}")->cache(3600)->queryOne()['library_name'];
                } catch (Exception $ex) {
                    
                }
                return $library_name ?: "OpenBiblio2";
            }),
    'modules' => [
        'gridview' => ['class' => 'kartik\grid\Module'],
    // accesos solo administrativos a módulos específicos
    ]
];
