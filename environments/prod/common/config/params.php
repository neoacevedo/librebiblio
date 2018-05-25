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
    'updateKey' => 'zxLxXJvZrUkKz8LuSJ', // key del OAuth
    'updateSecret' => 'nWF3gz2hjxXeETKkSLYtGbSRTQD7Qf22', // secret key del OAuth
    'version' => '2.18.5.25',
];
