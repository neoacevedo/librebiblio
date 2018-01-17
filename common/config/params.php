<?php

if ($hash = sprintf("%s", `git describe --all --long | cut -d "-" -f 3`)) {
    $version = "2.18.1.$hash";
} else {
    $version = "2.18.1.g45a7192";
}
return [
    'adminEmail' => getenv('USERNAME'),
    'supportEmail' => getenv('USERNAME'),
    // caducidad del token de renovación de la contraseña.
    'user.passwordResetTokenExpire' => 3600,
    'preferredLanguages' => ['es-CO', 'es-ES', 'en-GB'],
    'version' => $version
];
