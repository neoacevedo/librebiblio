<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

require __DIR__ . '/params.php';

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => YII_DEBUG ? yii\caching\DummyCache::class: 'yii\caching\FileCache',
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
    ],
    'version' => '22.06.29',
    'name' => call_user_func(function () use ($config) {
        try {
            $connection = new \yii\db\Connection($config['components']['db']);
            $connection->open();
            $library_name = $connection->createCommand("Select library_name from {{%settings}}")->cache(3600)->queryOne()['library_name'];
        } catch (Exception $ex) {
            $library_name = "LibreBiblio";
        }
        return $library_name;
    }),
    'modules' => [
        'gridview' => ['class' => 'kartik\grid\Module'],
    ]
];
