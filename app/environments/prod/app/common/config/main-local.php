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
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
        ],
    ]
];
