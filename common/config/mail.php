<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    'viewPath' => '@common/mail',
    'useFileTransport' => false, //for the testing purpose, you need to enable this
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => getenv('SMTP_HOST') ?: 'smtp.googlemail.com', // e.g. smtp.mandrillapp.com or smtp.gmail.com
        'username' => getenv('USERNAME') ?: 'nestor.acevedo.romero@gmail.com',
        'password' => getenv('PASSWORD') ?: "Hynt1b@2017",
        'port' => '587', // Port 25 is a very common port too
        'encryption' => 'tls', // It is often used, check your provider or mail server specs
    ],
];
