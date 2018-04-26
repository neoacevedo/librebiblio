<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

/**
 * Configuración de base de datos.
 */
$connectstr_dbhost = "localhost";
$connectstr_dbname = "openbiblio2";
$connectstr_dbusername = "postgres";
$connectstr_dbpassword = "";

return [
    'class' => 'yii\db\Connection',
    'dsn' => "pgsql:host=$connectstr_dbhost;dbname=$connectstr_dbname",
    'username' => $connectstr_dbusername,
    'password' => $connectstr_dbpassword,
    'charset' => 'utf8',
    'enableQueryCache' => true
];

