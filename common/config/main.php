<?php

$cache = require(__DIR__ . '/cache.php');
$db = require(__DIR__ . '/database.php');
$mailer = require(__DIR__ . '/mail.php');

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'America/Bogota',
    'components' => [
        'cache' => $cache,
        'db' => $db,
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
        'mailer' => $mailer,
    ],
    'name' => call_user_func(function() use($db) {
                array_shift($db);
                $connection = new \yii\db\Connection($db);
                $connection->open();
                try {
                    $library_name = $connection->createCommand("Select library_name from {{%settings}}")->cache(3600)->queryOne()['library_name'];
                } catch (Exception $ex) {
                    
                }
                return $library_name ?: "OpenBiblio2";
            }, $db),
    'modules' => [
        'gridview' => ['class' => 'kartik\grid\Module'],
        // accesos solo administrativos a módulos específicos
    ]
];
