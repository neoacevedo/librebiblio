<?php

$config = require(__DIR__ . "/../../common/config/main-local.php");
array_shift($config['components']['db']);

$connection = new \yii\db\Connection($config['components']['db']);
$connection->open();
$offline = (int) $connection->createCommand("Select offline from {{%settings}}")->cache(3600)->queryScalar();

return [
    //'adminEmail' => 'admin@example.com',
    'offline' => $offline,
    'offlineMessage' => '<h2>' . Yii::t('app', 'Maintenance Mode') . '</h2>'
];
