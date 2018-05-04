<?php

return [
    'adminEmail' => getenv('adminEmail'),
    'supportEmail' => getenv('supportEmail'),
    // caducidad del token de renovación de la contraseña.
    'user.passwordResetTokenExpire' => 3600,
    'preferredLanguages' => ['es-CO', 'en-US'],
    'version' => '2.18.5.4',
];
