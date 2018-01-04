<?php

$connectstr_dbhost = filter_input(INPUT_SERVER, "RDS_HOSTNAME") ?: "localhost";
$connectstr_dbname = filter_input(INPUT_SERVER, "RDS_DB_NAME") ?: "openbiblio2";
$connectstr_dbusername = filter_input(INPUT_SERVER, "RDS_USERNAME") ?: "root";
$connectstr_dbpassword = filter_input(INPUT_SERVER, "RDS_PASSWORD") ?: "";

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=$connectstr_dbhost;dbname=$connectstr_dbname",
    'username' => $connectstr_dbusername,
    'password' => $connectstr_dbpassword,
    'charset' => 'utf8',
    'enableQueryCache' => false
];

