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
 */

/**
 * Tipo de servicio
 * @var string
 */
define('STORAGE_SERVICE', '%%STORAGE_SERVICE%%');

// Amazon S3
define('AWS_KEY', '%%AWS_KEY%%');
define('AWS_SECRET_ACCES_KEY', '%%AWS_SECRET_ACCESS_KEY%%');
define('AWS_BUCKET', '%%AWS_BUCKET%%');
define('AWS_REGION', '%%AWS_REGION%%');
define('AWS_PREFIX', '%%AWS_PREFIX%%');

// Azure Storage Blob
define('AZURE_ACCOUNTNAME', '%%AZURE_ACCOUNTNAME%%');
define('AZURE_ACCOUNTKEY', '%%AZURE_ACCOUNTKEY%%');
define('AZURE_CONTAINER', '%%AZURE_CONTAINER%%');
define('AZURE_PREFIX', '%%AZURE_PREFIX%%');

// Google Cloud Storage
define('GCS_PROJECTID', '%%GCS_PROJECTID%%');
define('GCS_BUCKET', '%%GCS_BUCKET%%');
define('GCS_PREFIX', '%%GCS_PREFIX%%');

switch (STORAGE_SERVICE) {
  case "s3":
  case "S3":
    $storage = [
      'class' => 'neoacevedo\yii2\Storage',
      'service' => 's3',
      'config' => [
        'key' => AWS_KEY,
        'secret' => AWS_SECRET_ACCES_KEY,
        'bucket' => AWS_BUCKET,
        'region' => AWS_REGION
      ],
      'prefix' => AWS_PREFIX, // ruta al directorio de imágenes (Opcional)
    ];
    break;
  case "azure":
    $storage = [
      'class' => 'neoacevedo\yii2\Storage',
      'service' => 'azure',
      'config' => [
        'accountName' => AZURE_ACCOUNTNAME,
        'accountKey' => AZURE_ACCOUNTKEY,
        'container' => AZURE_CONTAINER
      ],
      'prefix' => AZURE_PREFIX // ruta al directorio de imágenes (Opcional)
    ];
    break;
  case "google":
    $storage = [
      'class' => 'neoacevedo\yii2\Storage',
      'service' => 'gcs',
      'config' => [
        'projectId' => GCS_PROJECTID,
        'bucket' => GCS_BUCKET,
        'keyFile' => '%%GCS_KEYFILE_CONTENT%%' // Contenido del archivo JSON generado en la consola de Google
      ],
      'prefix' => GCS_PREFIX // ruta al directorio de imágenes (Opcional)
    ];
    break;
  default:
    $storage = [
      'class' => 'neoacevedo\yii2\Storage',
      'service' => 'local',
      'config' => [
        'bucket' => '@frontend/web/', // reemplace @webroot por @frontend o @backend según sea el caso
      ],
      'prefix' => 'images/'
    ];
}

return $storage;
