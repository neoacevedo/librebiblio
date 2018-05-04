<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
$db = require(__DIR__ . '/../../common/config/database.php');
return [
    'pagination' => call_user_func(function() use($db) {
                try {
                    array_shift($db);
                    $connection = new \yii\db\Connection($db);
                    $connection->open();
                    $items_per_page = $connection->createCommand("Select items_per_page from {{%settings}}")->cache(3600)->queryOne()['items_per_age'];
                } catch (Exception $ex) {
                    $items_per_page = 20;
                }
                return $items_per_page;
            }),
];
