@if "%SCM_TRACE_LEVEL%" NEQ "4" @echo off

:: ----------------------
:: KUDU Deployment Script
:: Version: 1.0.15
:: ----------------------

:: Prerequisites
:: -------------

:: Verify node.js installed
where node 2>nul >nul
IF %ERRORLEVEL% NEQ 0 (
  echo Missing node.js executable, please install node.js, if already installed make sure it can be reached from current environment.
  goto error
)

:: Setup
:: -----

setlocal enabledelayedexpansion

SET ARTIFACTS=%~dp0%..\artifacts

IF NOT DEFINED DEPLOYMENT_SOURCE (
  SET DEPLOYMENT_SOURCE=%~dp0%.
)

IF NOT DEFINED DEPLOYMENT_TARGET (
  SET DEPLOYMENT_TARGET=%ARTIFACTS%\wwwroot
)

IF NOT DEFINED NEXT_MANIFEST_PATH (
  SET NEXT_MANIFEST_PATH=%ARTIFACTS%\manifest

  IF NOT DEFINED PREVIOUS_MANIFEST_PATH (
    SET PREVIOUS_MANIFEST_PATH=%ARTIFACTS%\manifest
  )
)

IF NOT DEFINED KUDU_SYNC_CMD (
  :: Install kudu sync
  echo Installing Kudu Sync
  call npm install kudusync -g --silent
  IF !ERRORLEVEL! NEQ 0 goto error

  :: Locally just running "kuduSync" would also work
  SET KUDU_SYNC_CMD=%appdata%\npm\kuduSync.cmd
)

::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
:: Deployment
:: ----------

echo Handling Basic Web Site deployment.

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
@echo "return [" > common/config/main-local.php
@echo "    'db' => [" > common/config/main-local.php
@echo "                'class' => 'yii\db\Connection'," > common/config/main-local.php
@echo "                'dsn' => 'mysql:host=localhost;dbname=openbiblio2'," > common/config/main-local.php
@echo "                'username' => 'azure'," > common/config/main-local.php
@echo "                'password' => 'password'," > common/config/main-local.php
@echo "                'charset' => 'utf8'," > common/config/main-local.php
@echo "            ]," > common/config/main-local.php
@echo "            'mailer' => [" > common/config/main-local.php
@echo "                'class' => 'yii\swiftmailer\Mailer'," > common/config/main-local.php
@echo "                'viewPath' => '@common/mail'," > common/config/main-local.php
@echo "                // send all mails to a file by default. You have to set" > common/config/main-local.php
@echo "                // 'useFileTransport' to false and configure a transport" > common/config/main-local.php
@echo "                // for the mailer to send real emails." > common/config/main-local.php
@echo "                'useFileTransport' => false," > common/config/main-local.php
@echo "                'transport' => [" > common/config/main-local.php
@echo "                    'class' => 'Swift_SmtpTransport'," > common/config/main-local.php
@echo "                    'host' => 'smtp.googlemail.com', // e.g. smtp.mandrillapp.com or smtp.gmail.com" > common/config/main-local.php
@echo "                    'username' => 'nestor.acevedo.romero'," > common/config/main-local.php
@echo "                    'password' => '_*Hynt1b@_*'," > common/config/main-local.php
@echo "                    'port' => '587', // Port 25 is a very common port too" > common/config/main-local.php
@echo "                    'encryption' => 'tls', // It is often used, check your provider or mail server specs" > common/config/main-local.php
@echo "                ]," > common/config/main-local.php
@echo "            ]," > common/config/main-local.php
@echo "            'gridview' => ['class' => 'kartik\grid\Module']" > common/config/main-local.php
@echo "        ]," > common/config/main-local.php
@echo "    ];" > common/config/main-local.php
@echo on

echo f | xcopy /f /y main-local.php common/config/main-local.php

echo ------------------------------------
echo  Migrando la base de datos.
echo ------------------------------------

php yii migrate

:: 1. KuduSync
IF /I "%IN_PLACE_DEPLOYMENT%" NEQ "1" (
  call :ExecuteCmd "%KUDU_SYNC_CMD%" -v 50 -f "%DEPLOYMENT_SOURCE%" -t "%DEPLOYMENT_TARGET%" -n "%NEXT_MANIFEST_PATH%" -p "%PREVIOUS_MANIFEST_PATH%" -i ".git;.hg;.deployment;deploy.cmd"
  IF !ERRORLEVEL! NEQ 0 goto error
)

::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
goto end

:: Execute command routine that will echo out when error
:ExecuteCmd
setlocal
set _CMD_=%*
call %_CMD_%
if "%ERRORLEVEL%" NEQ "0" echo Failed exitCode=%ERRORLEVEL%, command=%_CMD_%
exit /b %ERRORLEVEL%

:error
endlocal
echo An error has occurred during web site deployment.
call :exitSetErrorLevel
call :exitFromFunction 2>nul

:exitSetErrorLevel
exit /b 1

:exitFromFunction
()

:end
endlocal
echo Finished successfully.
