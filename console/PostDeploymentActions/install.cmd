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

Move-Item -Path "main-local.php" -Destination "%ARTIFACTS%\wwwroot\common\config\main-local.php"

echo ------------------------------------
echo  Migrando la base de datos.
echo ------------------------------------

php yii migrate

echo Finalizado.
