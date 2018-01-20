<?php

return [
    'adminEmail' => getenv('USERNAME'),
    'supportEmail' => getenv('USERNAME'),
    // caducidad del token de renovación de la contraseña.
    'user.passwordResetTokenExpire' => 3600,
    'preferredLanguages' => ['es-CO', 'es-ES', 'en-GB'],
    'version' => '2.18.1'
];
