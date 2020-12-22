<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

/**
 * Configuración de base de datos.
 */
define('DB_NAME', '%%DB_NAME%%');
define('DB_USERNAME', '%%DB_USERNAME%%');
define('DB_PASSWORD', '%%DB_PASSWORD%%');
define('DB_HOSTNAME', '%%DB_HOSTNAME%%');
define('DB_ENGINE', '%%DB_ENGINE%%');

return [
    'class' => 'yii\db\Connection',
    'dsn' => DB_ENGINE . ":host=" . DB_HOSTNAME . ";dbname=" . DB_NAME,
    'username' => DB_USERNAME,
    'password' => DB_PASSWORD,
    'charset' => 'utf8',
    'enableQueryCache' => true
];
