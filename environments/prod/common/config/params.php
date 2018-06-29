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
    'updateKey' => 'AFAF2ZeJ7QYSNfeB2h', // key del OAuth
    'updateSecret' => 'X64BEuBF3KXGfwbdLzTyWefz8gbPPRFZ', // secret key del OAuth
    'version' => '2.18.6.28'
];
