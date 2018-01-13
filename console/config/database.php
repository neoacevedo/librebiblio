<?php

$connectstr_dbhost = get_cfg_var("RDS_HOSTNAME");
$connectstr_dbname = get_cfg_var("RDS_DB_NAME");
$connectstr_dbusername = get_cfg_var("RDS_USERNAME");
$connectstr_dbpassword = get_cfg_var("RDS_PASSWORD");

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=$connectstr_dbhost;dbname=$connectstr_dbname",
    'username' => $connectstr_dbusername,
    'password' => $connectstr_dbpassword,
    'charset' => 'utf8',
    'enableQueryCache' => false
];

