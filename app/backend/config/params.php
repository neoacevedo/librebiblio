<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2022 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

$config = require(__DIR__ . "/../../common/config/main-local.php");
array_shift($config['components']['db']);

try {
    $connection = new \yii\db\Connection($config['components']['db']);
    $connection->open();
    $tableName = "{$connection->tablePrefix}settings";
    $items_per_page = $connection->createCommand("select items_per_page from {{%settings}}")->cache(86400)->queryScalar();
} catch (Exception $ex) {
    $message = $ex->getMessage();
    $items_per_page = 20;
    $theme = "AdminLTE";
}

return [
    'pagination' => $items_per_page,
    'bsVersion' => '4.x',
];
