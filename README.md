OpenBiblio2
===============================

OpenBiblio2 es un sistema automatizado de gestión bibliotecaria y OPAC desarrollado en PHP. Cuenta con características como Circulación, Catalogación, 
Administración de personal y usuarios.

OpenBiblio2 está basado en [OpenBiblio](http://obiblio.sourceforge.net/), desarrollado por Dave Stevens. 

Esta aplicación está creada con [Yii 2](http://www.yiiframework.com/) con la plantilla avanzada.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-app-advanced/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-app-advanced/downloads.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

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