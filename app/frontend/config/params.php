<?php

$config = require(__DIR__ . "/../../common/config/main-local.php");
array_shift($config['components']['db']);

$connection = new \yii\db\Connection($config['components']['db']);
$connection->open();
$offline = (int) $connection->createCommand("Select offline from {{%settings}}")->cache(3600)->queryScalar();

$catchAll = [];
if ($offline == 1) {
    $catchAll = [
        'site/offline'
    ];
}

return [
    //'adminEmail' => 'admin@example.com',
    'offlineMessage' => '<h2>' . Yii::t('app', 'Maintenance Mode') . '</h2>'
];
