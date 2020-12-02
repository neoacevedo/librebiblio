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
$storageService = filter_input(INPUT_SERVER | INPUT_ENV, "STORAGE_SERVICE");

// Amazon S3
$aws_key = filter_input(INPUT_SERVER | INPUT_ENV, "AWS_KEY");
$aws_secret_access_key = filter_input(INPUT_SERVER | INPUT_ENV, "AWS_SECRET_ACCESS_KEY");
$aws_bucket = filter_input(INPUT_SERVER | INPUT_ENV, "AWS_BUCKET");
$aws_region = filter_input(INPUT_SERVER | INPUT_ENV, "AWS_REGION");
$aws_prefix = filter_input(INPUT_SERVER | INPUT_ENV, "AWS_PREFIX");

// Azure Storage Blob
$azure_accountName = filter_input(INPUT_SERVER | INPUT_ENV, "AZURE_ACCOUNTNAME");
$azure_accountKey = filter_input(INPUT_SERVER | INPUT_ENV, "AZURE_ACCOUNTKEY");
$azure_container = filter_input(INPUT_SERVER | INPUT_ENV, "AZURE_CONTAINER");
$azure_prefix = filter_input(INPUT_SERVER | INPUT_ENV, "AZURE_PREFIX");

// Google Cloud Storage
$gcs_projectId = filter_input(INPUT_SERVER | INPUT_ENV, "GCS_PROJECTID");
$gcs_bucket = filter_input(INPUT_SERVER | INPUT_ENV, "GCS_BUCKET");
$gcs_keyFile = filter_input(INPUT_SERVER | INPUT_ENV, "GCS_KEYFILE_CONTENT"); # ESTO PARA REVISAR.
$gcs_prefix = filter_input(INPUT_SERVER | INPUT_ENV, "GCS_PREFIX");

switch ($storageService) {
  case "s3":
  case "S3":
    $storage = [
      'class' => 'neoacevedo\yii2\Storage',
      'service' => 's3',
      'config' => [
        'key' => $aws_key,
        'secret' => $aws_secret_access_key,
        'bucket' => $aws_bucket,
        'region' => $aws_region
      ],
      'prefix' => $aws_prefix, // ruta al directorio de imágenes (Opcional)
    ];
    break;
  case "azure":
    $storage = [
      'class' => 'neoacevedo\yii2\Storage',
      'service' => 'azure',
      'config' => [
        'accountName' => $azure_accountName,
        'accountKey' => $azure_accountKey,
        'container' => $azure_container
      ],
      'prefix' => $azure_prefix // ruta al directorio de imágenes (Opcional)
    ];
    break;
  case "google":
    $storage = [
      'class' => 'neoacevedo\yii2\Storage',
      'service' => 'gcs',
      'config' => [
        'projectId' => $gcs_projectId,
        'bucket' => $gcs_bucket,
        'keyFile' => $gcs_keyFile // Contenido del archivo JSON generado en la consola de Google
      ],
      'prefix' => $gcs_prefix // ruta al directorio de imágenes (Opcional)
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
