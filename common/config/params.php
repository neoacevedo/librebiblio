<?php

return [
    'adminEmail' => getenv('USERNAME'),
    'supportEmail' => getenv('USERNAME'),
    // caducidad del token de renovación de la contraseña.
    'user.passwordResetTokenExpire' => 3600,
    'preferredLanguages' => ['es-CO', 'en-US'],
    'version' => '2.18.2'
];
