<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "mysql:host=localhost;dbname=librebiblio", // "mysql:host=localhost;dbname=librebiblio" ó "pgsql:host=localhost;dbname=librebiblio",
            'username' => "root",
            'password' => '',
            'charset' => 'utf8',
            'enableQueryCache' => true
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false, //for the testing purpose, you need to enable this
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '', // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => '',
                'password' => '',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
        ],
    ]
];
