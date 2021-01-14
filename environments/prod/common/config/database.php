<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

/**
 * Configuración de base de datos.
 */
return [
    'class' => 'yii\db\Connection',
    'dsn' => "%%DB_ENGINE%%:host=%%DB_HOSTNAME%%;dbname=%%DB_NAME%%",
    'username' => "%%DB_USERNAME%%",
    'password' => '%%DB_PASSWORD%%',
    'charset' => 'utf8',
    'enableQueryCache' => true
];
