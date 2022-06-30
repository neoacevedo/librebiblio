<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

$config = require(__DIR__ . "/main-local.php");
array_shift($config['components']['db']);

return [
    'adminEmail' => '',
    'supportEmail' => '',
    // caducidad del token de renovación de la contraseña.
    'user.passwordResetTokenExpire' => 3600,
    'preferredLanguages' => ['es-CO'],
];
