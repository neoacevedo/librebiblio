curl -O https://getcomposer.org/composer.phar

@echo Ejecutando Composer

php composer.phar install

@echo ------------------------------------
@echo Iniciando Yii2 en modo Produccion
@echo ------------------------------------

php init --env=Production

@echo ------------------------------------
@echo Sobrescribiendo main-local.php
@echo ------------------------------------

$main-local = "<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";
// Parsing connnection string
foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_") !== 0) {
        continue;
    }
    $servername = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $username = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $password = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}
return [
    'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host='.$dbname.';dbname='.$dbname.',
                'username' => $username,
                'password' => $password,
                'charset' => 'utf8',
            ],
            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@common/mail',
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
                'useFileTransport' => false,
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => 'smtp.googlemail.com', // e.g. smtp.mandrillapp.com or smtp.gmail.com
                    'username' => 'nestor.acevedo.romero',
                    'password' => '_*Hynt1b@_*',
                    'port' => '587', // Port 25 is a very common port too
                    'encryption' => 'tls', // It is often used, check your provider or mail server specs
                ],
            ],
            'gridview' => ['class' => 'kartik\grid\Module']
        ],
    ];"

$main-local | Set-Content 'main-local.php'

xcopy /f /y main-local.php common/config/main-local.php

echo ------------------------------------
echo  Migrando la base de datos.
echo ------------------------------------

php yii migrate

echo Finalizado.
