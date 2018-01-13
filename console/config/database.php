<?php
$eb_config = sprintf("%s", `/opt/elasticbeanstalk/bin/get-config environment`);
$config = json_decode($eb_config);
$connectstr_dbhost = $config->RDS_HOSTNAME;
$connectstr_dbname = $config->RDS_DB_NAME;
$connectstr_dbusername = $config->RDS_USERNAME;
$connectstr_dbpassword = $config->RDS_PASSWORD;

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=$connectstr_dbhost;dbname=$connectstr_dbname",
    'username' => $connectstr_dbusername,
    'password' => $connectstr_dbpassword,
    'charset' => 'utf8',
    'enableQueryCache' => false
];

