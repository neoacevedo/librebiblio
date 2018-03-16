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
 */

// Amazon S3
return $storageService = [
    'class' => 'common\components\Storage',
    'service' => 's3',
    'config' => [
        'key' => 'AKIAJW5XGNDCS3ZGJ6XQ',
        'secret' => 'VYNoMIVe/JnpkJITyxqHJs4BUyP1s22EW7p17Ez2',
        'bucket' => 'pruebas-joomla',
        'region' => 'us-east-1',
    // 'version' => 'latest',
    // 'baseUrl' => 'your-base-url',
    // 'prefix' => 'your-prefix',
    // 'options' => [],
    ]
];

/*
  // Azure Blob Storage
  return $storageService = [
  'class' => 'common\components\Storage',
  'service' => 'azure',
  'config' => [
  'accountName' => 'your-account-name',
  'accountKey' => 'your-account-key',
  'container' => 'your-container',
 ]
  ];
 */
/*
  // Google Cloud Storage
  return $storageService = [
  'class' => 'common\components\Storage',
  'service' => 'gcs',
  'config' => [
  'projectId' => 'your-project-id',
  'bucket' => 'your-bucket',
  // 'prefix' => 'your-prefix',
  ]
  ];
 */

/*
  // Almacenamiento local
  return $storageService = [
  'class' => 'common\components\Storage',
  'service' => 'local',
  'config' => [
  'bucket' => '@webroot/your-writable-folder-to-save-files', // reemplace @webroot con la URL del frontend
  ]
  ];
 */


