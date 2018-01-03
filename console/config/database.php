<?php

/**
 * En aplicación de consola, no se hará uso de filter_input, sino que directamente se tomarán los valores.
 */
$connectstr_dbhost = "";
$connectstr_dbname = "";
$connectstr_dbusername = "";
$connectstr_dbpassword = "";

if (!$connectstr_dbhost = getenv("RDS_HOST_NAME")) {
    $connectstr_dbhost = "localhost";
}

if (!$connectstr_dbname = getenv("RDS_DB_NAME")) {
    $connectstr_dbname = "openbiblio2";
}

if (!$connectstr_dbname = getenv('RDS_USERNAME')) {
    $connectstr_dbusername = "root";
}

if (!$connectstr_dbpassword = getenv("RDS_PASSWORD")) {
    $connectstr_dbpassword = "";
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=$connectstr_dbhost;dbname=$connectstr_dbname",
    'username' => $connectstr_dbusername,
    'password' => $connectstr_dbpassword,
    'charset' => 'utf8',
    'enableQueryCache' => false
];

