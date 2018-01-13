<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    'viewPath' => '@common/mail',
    'useFileTransport' => false, //for the testing purpose, you need to enable this
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => getenv('SMTP_HOST'), // e.g. smtp.mandrillapp.com or smtp.gmail.com
        'username' => getenv('USERNAME'),
        'password' => getenv('PASSWORD'),
        'port' => '587', // Port 25 is a very common port too
        'encryption' => 'tls', // It is often used, check your provider or mail server specs
    ],
];
