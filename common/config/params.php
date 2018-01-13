<?php

if ($hash = sprintf("%s", `git describe --all --long | cut -d "-" -f 3`)) {
    $version = "2.18.1.$hash";
} else {
    $version = "2.18.1";
}
return [
    'adminEmail' => 'nestor.acevedo.romero@gmail.com',
    'supportEmail' => 'nestor.acevedo.romero@gmail.com',
    'user.passwordResetTokenExpire' => 3600,
    'preferredLanguages' => ['es-CO', 'es-ES', 'en-GB'],
    'version' => $version
];
