OpenBiblio2
===============================

OpenBiblio2 es un sistema automatizado de gestión bibliotecaria y OPAC desarrollado en PHP, basado en [OpenBiblio](http://obiblio.sourceforge.net/), 
desarrollado por Dave Stevens y desarrollada con [Yii 2](http://www.yiiframework.com/).

Cuenta con características conocidas de OpenBiblio como Circulación, Catalogación, Administración de personal y usuarios. 
Además permite el registro de miembros desde la parte administrativa y la pública.

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-app-advanced/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-app-advanced/downloads.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

INSTALACIÓN
===========
## Requerimientos

+ PHP 7
+ MySQL o MariaDB (Por ahora)

## Instalando desde Composer

Primero, se debe comprobar de que se tenga la última versión del plugin [Composer Assets](https://github.com/francoispluchino/composer-asset-plugin): 
    
    php composer.phar global require "fxp/composer-asset-plugin:^1.2.0"

Luego instalar OpenBiblio2 desde Composer:

    php composer.phar create-project neoacevedo/openbiblio2

## Desde un archivo comprimido

Descargue el archivo comprimido desde []() y proceda a descomprimirlo en el directorio raiz de su sitio web o en public_html 

## Preparando la aplicación

Al estar desarrollado en Yii2, los comandos para preparar la aplicación son básicamente los mismos. Estos pasos solo los ejecuta una sola vez.

1. Desde la terminal, ejecute el siguiente comando y elija el entorno de acuerdo al que requiera (dev o prod):
    
    php /ruta/al/directorio/de/openbiblio2 init

    De manera automatizada se pueden especificar el entorno bajo el que correrá la aplicación:

    php /ruta/al/directorio/de/openbiblio2/init --env=Production --overwrite=All

2. Si no lo ha hecho, cree una base de datos. Posterior a ello sobreescriba el archivo `common/config/main-local.php`con los de **main.php** 
   y modifique los valores de la configuración de base de datos de acuerdo a su entorno:

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

5. Opcional en desarrollo, OBLIGATORIO EN PRODUCCIÓN. Ajuste los host virtuales.

En Apache:

```
    <VirtualHost *:80>
        ServerName openbiblio2.tld
        DocumentRoot "/ruta/al/directorio/de/openbiblio2/frontend/web/"
        
        <Directory "/ruta/al/directorio/de/openbiblio2/frontend/web/">
            # use mod_rewrite for pretty URL support
            RewriteEngine on
            # If a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # Otherwise forward the request to index.php
            RewriteRule . index.php

            # use index.php as index file
            DirectoryIndex index.php

            # ...other settings...
            # Apache 2.4
            Require all granted
            
            ## Apache 2.2
            # Order allow,deny
            # Allow from all
        </Directory>
    </VirtualHost>
    
    <VirtualHost *:80>
        ServerName backend.openbiblio2.tld
        DocumentRoot "/ruta/al/directorio/de/openbiblio2/backend/web/"
        
        <Directory "/ruta/al/directorio/de/openbiblio2/backend/web/">
            # use mod_rewrite for pretty URL support
            RewriteEngine on
            # If a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # Otherwise forward the request to index.php
            RewriteRule . index.php

            # use index.php as index file
            DirectoryIndex index.php

            # ...other settings...
            # Apache 2.4
            Require all granted
            
            ## Apache 2.2
            # Order allow,deny
            # Allow from all
        </Directory>
    </VirtualHost>
``` 
En nginx:

```
    server {
        charset utf-8;
        client_max_body_size 128M;

        listen 80; ## listen for ipv4
        #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

        server_name frontend.test;
        root        /ruta/al/directorio/de/openbiblio2/frontend/web/;
        index       index.php;

        access_log  /ruta/al/directorio/de/openbiblio2/log/frontend-access.log;
        error_log   /ruta/al/directorio/de/openbiblio2/log/frontend-error.log;

        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php$is_args$args;
        }

        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;

        # deny accessing php files for the /assets directory
        location ~ ^/assets/.*\.php$ {
            deny all;
        }

        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass 127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }
    
        location ~* /\. {
            deny all;
        }
    }
     
    server {
        charset utf-8;
        client_max_body_size 128M;
    
        listen 80; ## listen for ipv4
        #listen [::]:80 default_server ipv6only=on; ## listen for ipv6
    
        server_name backend.test;
        root        /ruta/al/directorio/de/openbiblio2/backend/web/;
        index       index.php;
    
        access_log  /ruta/al/directorio/de/openbiblio2/log/backend-access.log;
        error_log   /ruta/al/directorio/de/openbiblio2/log/backend-error.log;
    
        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php$is_args$args;
        }
    
        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;

        # deny accessing php files for the /assets directory
        location ~ ^/assets/.*\.php$ {
            deny all;
        }

        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass 127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }
    
        location ~* /\. {
            deny all;
        }
    }
```

Hecho esto, puede acceder al backend desde la URL configurada _backend.openbiblio2.tld_ con usuario y contraseña **_admin_**

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