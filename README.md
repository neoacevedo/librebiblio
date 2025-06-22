LibreBiblio
===============================

LibreBiblio es un sistema automatizado de gestión bibliotecaria y OPAC, [![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/), 
basado en [OpenBiblio](http://obiblio.sourceforge.net/), desarrollado por Dave Stevens.

Cuenta con características conocidas de OpenBiblio como Circulación, Catalogación, Administración de personal y usuarios. 
Además permite el registro de miembros desde la parte administrativa y la pública.

<!-- [![Latest Stable Version](https://poser.pugx.org/neoacevedo/librebiblio/v/stable)](https://packagist.org/packages/neoacevedo/librebiblio)
[![Total Downloads](https://poser.pugx.org/neoacevedo/librebiblio/downloads)](https://packagist.org/packages/neoacevedo/librebiblio)
[![Latest Unstable Version](https://poser.pugx.org/neoacevedo/librebiblio/v/unstable)](https://packagist.org/packages/neoacevedo/librebiblio)
[![License](https://poser.pugx.org/neoacevedo/librebiblio/license)](https://packagist.org/packages/neoacevedo/librebiblio)
[![Monthly Downloads](https://poser.pugx.org/neoacevedo/librebiblio/d/monthly)](https://packagist.org/packages/neoacevedo/librebiblio)
[![Daily Downloads](https://poser.pugx.org/neoacevedo/librebiblio/d/daily)](https://packagist.org/packages/neoacevedo/librebiblio) -->

INSTALACIÓN
===========
## Requerimientos

+ PHP >= 8.3
+ MySQL, MariaDB, PostgresSQL (Por ahora)
+ PHP8 bcmath

## Configuración

Desde la web, verifique las extensiones de PHP: _http://<su-dominio>/requirements.php_

Ejecute el siguiente comando:
`php requirements.php`

Obtendrá información sobre su servidor para identificar si cumple con los requerimientos. Instale los módulos PHP que hagan falta.

## Preparando la aplicación

Al estar desarrollado en Yii2, los comandos para preparar la aplicación son básicamente los mismos. Estos pasos solo los ejecuta una sola vez.

1. Desde la terminal, ejecute el siguiente comando y elija el entorno de acuerdo al que requiera (dev o prod):
    
    php /ruta/al/directorio/de/librebiblio/app init

    De manera automatizada se pueden especificar el entorno bajo el que correrá la aplicación:

    php /ruta/al/directorio/de/librebiblio/app init --env=Production --overwrite=All

2. Si no lo ha hecho, cree una base de datos. Posterior a ello modifique los parámetros de conexión en el archivo `common/config/main-local.php`
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

    php /ruta/al/directorio/de/librebiblio/yii migrate

5. Configurar el servidor web. Para Apache, puede usar la siguiente configuración:
   
    ```
    <VirtualHost *:80>
        ServerName librebiblio.neoacevedo.co
        ServerAlias librebiblio.neoacevedo.co
        # ej: /var/www/html/
        DocumentRoot "/path/to/your/site/"
        <Directory "/path/to/your/site/">
          AllowOverride All
        </Directory>
    </VirtualHost>
    ```

Hecho esto, puede acceder al sitio web desde la URL configurada - por ejemplo, librebiblio.neoacevedo.co - 

También puede acceder a la administración del sitio con la ruta _/backend/web_ con usuario y contraseña **_admin_**

ESTRUCTURA DE DIRECTORIOS
-------------------

```
/                    contains the frontend entry script, favicon, and robots.txt.             
assets/              contains the frontend web runtime assets    
css/                 contiene los archivos css del sitio público         
images/              contiene imágnes del sitio público     
backend
    web/                 contains the backend entry script and Web resources
app
    common
        components/          contiene los componentes del sistema
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
        components/          contiene los componentes del nivel de backend
        config/              contains backend configurations
        controllers/         contains Web controller classes
        reports/             contiene clases modelo específicas para la generación de reportes 
        models/              contains backend-specific model classes
        runtime/             contains files generated during runtime
        themes/              contiene los temas del backend
        tmp/                 directorio temporal específico para la carga de archivos de tema.
        tests/               contains tests for backend application    
        views/               contains view files for the Web application
    frontend
        assets/              contains application assets such as JavaScript and CSS
        components/          contiene los componentes del nivel de frontend
        config/              contains frontend configurations
        controllers/         contains Web controller classes
        models/              contains frontend-specific model classes
        runtime/             contains files generated during runtime
        themes/              contiene los temas del frontend
        tests/               contains tests for frontend application
        views/               contains view files for the Web application
        widgets/             contains frontend widgets
    vendor/                  contains dependent 3rd-party packages
    environments/            contains environment-based overrides
```