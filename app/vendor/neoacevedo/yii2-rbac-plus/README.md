yii2-rbac-plus
=============
[![Latest Stable Version](https://poser.pugx.org/neoacevedo/yii2-rbac-plus/v/stable)](https://packagist.org/packages/neoacevedo/yii2-rbac-plus)
[![Total Downloads](https://poser.pugx.org/neoacevedo/yii2-rbac-plus/downloads)](https://packagist.org/packages/neoacevedo/yii2-rbac-plus)
[![Latest Unstable Version](https://poser.pugx.org/neoacevedo/yii2-rbac-plus/v/unstable)](https://packagist.org/packages/neoacevedo/yii2-rbac-plus)

Administrador de control de acceso basado en función de base de datos para yii2.


Características
------------
+ Operaciones CRUD para roles, permisos y reglas
+ Permite asignar múltiples roles a un usuario
+ Diseño agradable para integrar de inmediato


Instalación
------------

La forma preferida de instalar esta extensión es a través de [composer](http://getcomposer.org/download/).

Luego ejecute

```
php composer.phar require --prefer-dist neoacevedo/yii2-rbac-plus
```

o agregue

```
"neoacevedo/yii2-rbac-plus": "*"
```

a la sección require de su archivo `composer.json`.


Uso
-----
1. Vamos a agregar a la configuración de los módulos en su archivo de configuración principal

```php
'components' => [
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
    ],
],
'modules' => [
    'rbac' =>  [
        'class' => 'neoacevedo\rbacplus\Module'
    ]       
]
````

Luego, actualice el esquema de la base de datos 

````
$ php yii migrate/up --migrationPath=@yii/rbac/migrations
````

Eso es todo. Estas son las rutas disponibles:

+ /rbac/rule
+ /rbac/permission
+ /rbac/role
+ /rbac/assignment

2. Configuración para el módulo:

```php
'modules' => [
    'rbac' =>  [
        'class' => 'neoacevedo\rbacplus\Module',
        'userModelClassName'=>null,
        'userModelIdField'=>'id',
        'userModelLoginField'=>'username',
        'userModelLoginFieldLabel'=>null,
        'userModelExtraDataColumls'=>null,
        'beforeCreateController'=>null,
        'beforeAction'=>null
    ]       
]
````

+ <b>userModelClassName</b>: La clase del modelo 'user'.<br>
 Si no establece o establece nulo, <b>RBAC Plus</b> se obtendrá de `Yii::$app->getUser()->identityClass`
+ <b>userModelIdField</b>: El campo de id del modelo 'user'.<br>
 El campo de Id predeterminado es 'id', debe establecer esta configuración si la clave principal de la tabla de usuario en la base de datos no es 'id'.
+ <b>userModelLoginField</b>: El campo de inicio de sesión del modelo 'user'.<br>
 El campo de inicio de sesión predeterminado es 'username'. Tal vez use un campo de correo electrónico o algo diferente para iniciar sesión. Entonces debe cambiar esta configuración
+ <b>userModelLoginFieldLabel</b>: La etiqueta del campo de inicio de sesión del modelo 'user'.<br>
 Si establece nulo, la etiqueta se obtendrá de `$userModelClass->attributeLabels()[$userModelLoginField]`
+ <b>userModelExtraDataColumls</b>: Las columnas de datos adicionales que desea mostrar en las vistas de asignar usuario.<br>
 El valor predeterminado en la vista de cuadrícula de datos de asignación solo muestra los datos de la identificación y de la columna de inicio de sesión. Si quiere agregar la columna created_at, puede agregar
 
```php 
'userModelExtraDataColumls'=>[
    [
        'attributes'=>'created_at',
        'value'=>function($model){
            return date('m/d/Y', $model->created_at);
        }
    ]
]
````
+ <b>beforeCreateController</b>: El invocable antes de crear todo el controlador del módulo <b>Rbac Plus</b>.
El valor predeterminado es nulo. Necesita configurar esto cuando quiere restringir el acceso al módulo <b>Rbac Plus</b>.<br>
Ejemplo:

```php
'beforeCreateController'=>function($route){
    /**
    *@var string $route The route consisting of module, controller and action IDs.
    */    
}
````
+ <b>beforeAction</b>: El invocable antes de la acción de todo el controlador en el módulo <b>Rbac Plus</b>.<br>
El valor predeterminado es nulo. Necesita configurar esto cuando desee restringir el acceso a cualquier acción en algún controlador del módulo <b>Rbac Plus</b> <br>
Ejemplo:

```php
'beforeAction'=>function($action){
    /**
    *@var yii\base\Action $action the action to be executed.
    */    
}
````
___

¿CÓMO USARLO?
---
Los permisos pueden ser nombres únicos (*permissionName*) o rutas (*/user/create*). Para este último, Yii2 RBAC Plus despliega una lista de todas las rutas del sitio web.

Una vez haya creado los roles, permisos (opcionalmente las reglas de estos permisos) y haya asignado los permisos a los roles y haya asignado los roles a los usuarios, puede llamar desde el método `action` de su controlador:

```php
public function actionCreate() 
{
	if(\Yii::$app->user->can("permissionName")) {
	    ...
	}
}
```
Dentro del `if` ingrese la lógica que requiera el evento `action` de su controlador.

Puede optar también por crear una clase dentro de _@app/filters_ y desde el método **_beforeAction_** e invocar el código anterior, devolviendo un **true** en caso de que el usuario tenga el permiso asignado o **false** en caso contrario.
