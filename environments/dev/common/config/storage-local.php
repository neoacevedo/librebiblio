<?php

/*
 * Configure acá el sistema de archivos.
 * Esta configuración permite elegir alguno de los proveedores de almacenamiento en nube.
 * 
 * Los siguientes son aceptados:
 * * Amazon S3
 * * Azure Blob Storage
 * * Google Cloud Storage
 * * Local (en el propio equipo).
 * 
 * Descomente la configuración para el sistema de archivos que desee usar.
 * Comente las configuraciones que no desee usar.
 * Se puede usar una segunda configuración del mismo servicio si se desea por ejemplo, usar un prefix diferente.
 */

// Amazon S3
return $storageService = [
    'class' => 'common\components\Storage',
    'service' => 's3',
    'config' => [
        'key' => '',
        'secret' => '',
        'bucket' => '',
        'region' => '',
        'prefix' => '', // ruta al directorio de imágenes (Opcional)
    ]
];


// Azure Blob Storage
/* return $storageService = [
  'class' => 'common\components\Storage',
  'service' => 'azure',
  'config' => [
  'accountName' => '',
  'accountKey' => '',
  'container' => '',
  'prefix' => '' // ruta al directorio de imágenes (Opcional)
  ]
  ]; */


// Google Cloud Storage
/* return $storageService = [
  'class' => 'common\components\Storage',
  'service' => 'gcs',
  'config' => [
  'projectId' => '',
  'bucket' => 'your-bucket',
  'prefix' => '', // ruta al directorio de imágenes (Opcional)
  'keyFile' => '' // Contenido del archivo JSON generado en la consola de Google
  ]
  ]; */


// Almacenamiento local
/*return $storageService = [
    'class' => 'common\components\Storage',
    'service' => 'local',
    'config' => [
        'path' => '@frontend/web/images/covers/', // reemplace @webroot por @frontend o @backend según sea el caso
    ]
];*/



