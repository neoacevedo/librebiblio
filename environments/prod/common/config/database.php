<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

/**
 * Configuración de base de datos.
 */
$connectstr_dbhost = filter_input(INPUT_SERVER, "RDS_HOSTNAME");
$connectstr_dbname = filter_input(INPUT_SERVER, "RDS_DB_NAME");
$connectstr_dbusername = filter_input(INPUT_SERVER, "RDS_USERNAME");
$connectstr_dbpassword = filter_input(INPUT_SERVER, "RDS_PASSWORD");

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=$connectstr_dbhost;dbname=$connectstr_dbname",
    'username' => $connectstr_dbusername,
    'password' => $connectstr_dbpassword,
    'charset' => 'utf8',
    'enableQueryCache' => true
];

