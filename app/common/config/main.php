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
            'class' => $settings['cache_handler'],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //'defaultRoles' => ['admin', 'staff', 'user'],
        ],
        'storage' => [
            'class' => 'neoacevedo\yii2\storage\LocalStorage',
            'config' => [
                'baseUrl' => '/',
                'directory' => dirname(__DIR__, 3) . "/", // reemplace @webroot por @frontend o @backend según sea el caso. La ruta debe terminar con una barra diagonal
                'extensions' => 'pdf, jpg, jpeg, gif, png, bmp, webp'
            ],
            'prefix' => 'images/',
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
            ],
        ],
    ],
    'version' => '22.06.29',
    'name' => $settings['library_name'],
    'modules' => [
        'gridview' => ['class' => 'kartik\grid\Module'],
    ]
];
