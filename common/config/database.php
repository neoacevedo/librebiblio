<?php

// Azure MySQL in-app 
foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }

    $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}

$connectstr_dbhost = (null !== $connectstr_dbhost) ? $connectstr_dbhost : "localhost";
$connectstr_dbname = (null !== $connectstr_dbname) ? $connectstr_dbname : "openbiblio2";
$connectstr_dbusername = (null !== $connectstr_dbusername) ? $connectstr_dbusername : "root";
$connectstr_dbpassword = (null !== $connectstr_dbpassword) ? $connectstr_dbpassword : "";

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=$connectstr_dbhost;dbname=$connectstr_dbname",
    'username' => $connectstr_dbusername,
    'password' => $connectstr_dbpassword,
    'charset' => 'utf8',
    'enableQueryCache' => false
];

