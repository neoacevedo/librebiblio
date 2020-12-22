<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
$cache = require(__DIR__ . '/cache-local.php');
$db = require(__DIR__ . '/database-local.php');
$fs = require(__DIR__ . '/storage-local.php');

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
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
                'biblio*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'biblio' => 'biblio.php',
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
                'cataloging*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'cataloging' => 'cataloging.php',
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
                'library*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'library' => 'library.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'member*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'library' => 'member.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                ]
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false, //for the testing purpose, you need to enable this
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '', // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => '',
                'password' => "",
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
        ],
        'storage' => $fs
    ],
    'name' => call_user_func(function() use($db) {
                try {
                    array_shift($db);
                    $connection = new \yii\db\Connection($db);
                    $connection->open();
                    $library_name = $connection->createCommand("Select library_name from {{%settings}}")->cache(3600)->queryOne()['library_name'];
                } catch (Exception $ex) {
                    $library_name = "OpenBiblio2";
                }
                return $library_name;
            }),
    'modules' => [
        'gridview' => ['class' => 'kartik\grid\Module'],
    // accesos solo administrativos a módulos específicos
    ]
];
