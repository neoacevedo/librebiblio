<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2022 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

$config = require(__DIR__ . "/main-local.php");
array_shift($config['components']['db']);

try {
    $connection = new \yii\db\Connection($config['components']['db']);
    $connection->open();
    $tableName = "{$connection->tablePrefix}settings";
    $settings = $connection->createCommand("select * from {{%settings}} limit 1")->cache(86400)->queryOne(PDO::FETCH_ASSOC);
} catch (Exception $ex) {
    $message = $ex->getMessage();
    $settings['library_name'] = "LibreBiblio";
    $settings['library_hours'] = "L-V 09:00 - 17:00";
    $settings['library_phone'] = "+57 601234567";
    $settings['library_image_url'] = null;
    $settings['use_image_flg'] = 0;
    $settings['cache_handler'] = yii\caching\FileCache::class;
}

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 16,
    'bsVersion' => '4.x',
    'library_hours' => $settings['library_hours'],
    'library_phone' => $settings['library_phone'],
    'library_image_url' => $settings['library_image_url'],
    'use_image_flg' => $settings['use_image_flg'],
];
