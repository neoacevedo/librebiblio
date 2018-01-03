<?php

$connectstr_dbhost = "";
$connectstr_dbname = "";
$connectstr_dbusername = "";
$connectstr_dbpassword = "";

if (!$connectstr_dbhost = filter_input(INPUT_SERVER, "RDS_HOSTNAME")) {
    $connectstr_dbhost = "localhost";
}

if (!$connectstr_dbname = filter_input(INPUT_SERVER, "RDS_DB_NAME")) {
    $connectstr_dbname = "openbiblio2";
}

if (!$connectstr_dbusername = filter_input(INPUT_SERVER, "RDS_USERNAME")) {
    $connectstr_dbusername = "root";
}

if (!$connectstr_dbpassword = filter_input(INPUT_SERVER, "RDS_PASSWORD")) {
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

