<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

/**
 * Configuración de base de datos.
 */
$connectstr_dbhost = filter_input(INPUT_SERVER, "DB_HOSTNAME") ?? getenv("DB_HOSTNAME");
$connectstr_dbname = filter_input(INPUT_SERVER, "DB_NAME") ?? getenv("DB_NAME");
$connectstr_dbusername = filter_input(INPUT_SERVER, "DB_USERNAME") ?? getenv("DB_USERNAME");
$connectstr_dbpassword = filter_input(INPUT_SERVER, "DB_PASSWORD") ?? getenv("DB_PASSWORD");
$connectstr_dbengine = filter_input(INPUT_SERVER, "DB_ENGINE") ?? getenv("DB_ENGINE");

return [
    'class' => 'yii\db\Connection',
    'dsn' => "$connectstr_dbengine:host=$connectstr_dbhost;dbname=$connectstr_dbname",
    'username' => $connectstr_dbusername,
    'password' => $connectstr_dbpassword,
    'charset' => 'utf8',
    'enableQueryCache' => true
];

