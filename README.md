OpenBiblio2
===============================

OpenBiblio2 es un sistema automatizado de gestión bibliotecaria y OPAC desarrollado en PHP con [Yii 2](http://www.yiiframework.com/), 
basado en [OpenBiblio](http://obiblio.sourceforge.net/), desarrollado por Dave Stevens.

Cuenta con características conocidas de OpenBiblio como Circulación, Catalogación, Administración de personal y usuarios. 
Además permite el registro de miembros desde la parte administrativa y la pública.

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)

[![Latest Stable Version](https://poser.pugx.org/neoacevedo/openbiblio2/v/stable)](https://packagist.org/packages/neoacevedo/openbiblio2)
[![Total Downloads](https://poser.pugx.org/neoacevedo/openbiblio2/downloads)](https://packagist.org/packages/neoacevedo/openbiblio2)
[![Latest Unstable Version](https://poser.pugx.org/neoacevedo/openbiblio2/v/unstable)](https://packagist.org/packages/neoacevedo/openbiblio2)
[![License](https://poser.pugx.org/neoacevedo/openbiblio2/license)](https://packagist.org/packages/neoacevedo/openbiblio2)
[![Monthly Downloads](https://poser.pugx.org/neoacevedo/openbiblio2/d/monthly)](https://packagist.org/packages/neoacevedo/openbiblio2)
[![Daily Downloads](https://poser.pugx.org/neoacevedo/openbiblio2/d/daily)](https://packagist.org/packages/neoacevedo/openbiblio2)

INSTALACIÓN
===========
## Requerimientos

+ PHP 7
+ MySQL o MariaDB (Por ahora)

## Instalando desde Composer

Primero, se debe comprobar de que se tenga la última versión del plugin [Composer Assets](https://github.com/francoispluchino/composer-asset-plugin): 
    
    php composer.phar global require "fxp/composer-asset-plugin:^1.2.0"

Luego instalar OpenBiblio2 desde Composer:

    php composer.phar create-project --prefer-dist neoacevedo/openbiblio2

## Desde un archivo comprimido

Descargue el archivo comprimido desde [Github](https://github.com/neoacevedo/openbiblio2/archive/2.18.1.zip) y proceda a descomprimirlo en el directorio raiz de su sitio web o en public_html 

## Preparando la aplicación

Al estar desarrollado en Yii2, los comandos para preparar la aplicación son básicamente los mismos. Estos pasos solo los ejecuta una sola vez.

1. Desde la terminal, ejecute el siguiente comando y elija el entorno de acuerdo al que requiera (dev o prod):
    
    php /ruta/al/directorio/de/openbiblio2 init

    De manera automatizada se pueden especificar el entorno bajo el que correrá la aplicación:

    php /ruta/al/directorio/de/openbiblio2/init --env=Production --overwrite=All

2. Si no lo ha hecho, cree una base de datos. Posterior a ello modifique los parámetros de conexión en el archivo `common/config/database.php`
   de acuerdo a su entorno:

    ```
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => "mysql:host=your-local-host;dbname=your-database-name",
        'username' => 'your-username',
        'password' => 'your-password',
        'charset' => 'utf8',
        'enableQueryCache' => true
    ],
    ```

3. De manera predefinida la caché y la sesión se manejan desde **Memcached**. Esto se puede modificar desde el archivo 
`common/config/cache.php` modificando el valor `$cache['class'] = "yii\caching\MemCache";` por `$cache['class'] = 'yii\caching\FileCache';`

4. Desde la terminal, ejecute las migraciones:

    php /ruta/al/directorio/de/openbiblio2/yii migrate

5. Seguir las instrucciones para [configurar un servidor web en Yii2](http://www.yiiframework.com/doc-2.0/guide-start-installation.html#configuring-web-servers).

Hecho esto, puede acceder al backend desde la URL configurada - por ejemplo, _backend.openbiblio2.tld_ - con usuario y contraseña **_admin_**

ESTRUCTURA DE DIRECTORIOS
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    reports/             contiene clases modelo específicas para la generación de reportes 
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    themes/              contiene los temas del backend
    tmp/                 directorio temporal específico para la carga de archivos de tema.
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    themes/              contiene los temas del frontend
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```