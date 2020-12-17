<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
return [
    'adminEmail' => getenv('adminEmail'),
    'supportEmail' => getenv('supportEmail'),
    // caducidad del token de renovación de la contraseña.
    'user.passwordResetTokenExpire' => 3600,
    'preferredLanguages' => ['es-CO', 'en-US'],
    'version' => '2.20.12.14'
];
