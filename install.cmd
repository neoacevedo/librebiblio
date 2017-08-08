curl -O https://getcomposer.org/composer.phar

echo Ejecutando Composer

php composer.phar install

echo ------------------------------------
echo Iniciando Yii2 en modo Produccion
echo ------------------------------------

php init --env=Production

echo ------------------------------------
echo Sobrescribiendo main-local.php
echo ------------------------------------

@echo off
@echo "<?php" > main-local.php
@echo "return [" >> main-local.php
@echo "    'db' => [" > common/config/main-local.php
@echo "                'class' => 'yii\db\Connection'," >> main-local.php
@echo "                'dsn' => 'mysql:host=localhost;dbname=openbiblio2'," >> main-local.php
@echo "                'username' => 'azure'," >> main-local.php
@echo "                'password' => 'password'," >> main-local.php
@echo "                'charset' => 'utf8'," >> main-local.php
@echo "            ]," >> main-local.php
@echo "            'mailer' => [" >> main-local.php
@echo "                'class' => 'yii\swiftmailer\Mailer'," >> main-local.php
@echo "                'viewPath' => '@common/mail'," >> main-local.php
@echo "                // send all mails to a file by default. You have to set" >> main-local.php
@echo "                // 'useFileTransport' to false and configure a transport" >> main-local.php
@echo "                // for the mailer to send real emails." >> main-local.php
@echo "                'useFileTransport' => false," >> main-local.php
@echo "                'transport' => [" >> main-local.php
@echo "                    'class' => 'Swift_SmtpTransport'," >> main-local.php
@echo "                    'host' => 'smtp.googlemail.com', // e.g. smtp.mandrillapp.com or smtp.gmail.com" >> main-local.php
@echo "                    'username' => 'nestor.acevedo.romero'," >> main-local.php
@echo "                    'password' => '_*Hynt1b@_*'," >> main-local.php
@echo "                    'port' => '587', // Port 25 is a very common port too" >> main-local.php
@echo "                    'encryption' => 'tls', // It is often used, check your provider or mail server specs" >> main-local.php
@echo "                ]," >> main-local.php
@echo "            ]," >> main-local.php
@echo "            'gridview' => ['class' => 'kartik\grid\Module']" >> main-local.php
@echo "        ]," >> main-local.php
@echo "    ];" >> main-local.php
@echo on

echo f | xcopy /f /y main-local.php common/config/main-local.php

echo ------------------------------------
echo  Migrando la base de datos.
echo ------------------------------------

php yii migrate

