<?php

$connectstr_dbhost = getenv("RDS_HOSTNAME");
$connectstr_dbname = getenv("RDS_DB_NAME");
$connectstr_dbusername = getenv("RDS_USERNAME");
$connectstr_dbpassword = getenv("RDS_PASSWORD");

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=$connectstr_dbhost;dbname=$connectstr_dbname",
    'username' => $connectstr_dbusername,
    'password' => $connectstr_dbpassword,
    'charset' => 'utf8',
    'enableQueryCache' => false
];

