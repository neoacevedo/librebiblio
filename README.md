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
-----------
REQUERIMIENTOS
-----
PHP 7

Instalando desde Composer
___
Primero, se debe comprobar de que se tenga la última versión del plugin [Composer Assets](https://github.com/francoispluchino/composer-asset-plugin): 
`php composer.phar global require "fxp/composer-asset-plugin:^1.2.0"`

Luego instalar OpenBiblio2 desde Composer:
`php composer.phar create-project neoacevedo/openbiblio2`




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