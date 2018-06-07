<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace common\components;

use \yii\web\HttpException;
use \Aws\S3\Exception\S3Exception;
use \Aws\S3\S3Client;
use \MicrosoftAzure\Storage\Blob\BlobRestProxy;
use \MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;
use \MicrosoftAzure\Storage\Common\ServiceException as AzureStorageException;
use \MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use \Google\Cloud\Storage\StorageClient;
use \Google\Cloud\Core\Exception\ServiceException as GoogleClodStorageException;
use DateTime;
use \Google\Cloud\Core\Timestamp;

/**
 * Storage
 * 
 * Componente que hace uso del archivo
 */
class Storage extends \yii\base\BaseObject 
{

    const AWS_S3 = 's3';
    const AZURE_BLOB_STORAGE = 'azure';
    const GOOGLE_CLOUD_STORAGE = 'gcs';
    const LOCAL = 'local';

    public $service;
    public $config = [];
    public $prefix;
    private $clientService;
    private $bucket;

    /**
     * @inheritdoc
     */
    public function __construct($config = array()) {
        parent::__construct($config);
        switch ($this->service) {
            case self::AWS_S3:
                $this->clientService = new S3Client([
                    "credentials" => [
                        "key" => $this->config['key'], "secret" => $this->config['secret']
                    ],
                    "region" => $this->config['region'],
                    "version" => "2006-03-01"]);
                $this->bucket = $this->config['bucket'];
                $this->prefix = $this->config['prefix'];
                break;
            case self::AZURE_BLOB_STORAGE:
                $connectionString = "DefaultEndpointsProtocol=http;AccountName=" . $this->config['accountName'] . ";AccountKey=" . $this->config['accountKey'];
                $this->clientService = BlobRestProxy::createBlobService($connectionString);
                $this->bucket = $this->config['container'];
                $this->prefix = $this->config['prefix'];
                break;
            case self::GOOGLE_CLOUD_STORAGE:
                $this->clientService = new StorageClient([
                    'keyFile' => json_decode($this->config['keyFile'], true),
                    'projectId' => $this->config['projectId']]);
                ;
                $this->bucket = $this->config['bucket'];
                $this->prefix = $this->config['prefix'];
                break;
            case self::LOCAL:
            default:
                $this->bucket = $this->config['bucket'];
                $this->prefix = $this->config['prefix'];
        }
    }

    /**
     * Sube el archivo al servicio de almacenamiento.
     * @param \yii\web\UploadedFile $file El archivo real.
     * 
     * Este parámetro se pasa como el atributo del modelo de tipo UploadedFile.
     */
    public function saveAs($file) {
        switch ($this->service) {
            case self::AWS_S3:
                $this->uploadToS3($file);
                break;
            case self::AZURE_BLOB_STORAGE:
                $this->uploadToAzure($file);
                break;
            case self::GOOGLE_CLOUD_STORAGE:
                $this->uploadToGoogle($file);
                break;
            case self::LOCAL:
            default:
                $this->uploadToLocal($file);
        }
    }

    /* public function read($file) {
      switch ($this->service) {
      case self::AWS_S3:
      $this->uploadToS3($file);
      break;
      case self::AZURE_BLOB_STORAGE:
      $this->uploadToAzure($file);
      break;
      case self::GOOGLE_CLOUD_STORAGE:
      $this->uploadToGoogle($file);
      break;
      case self::LOCAL:
      default:
      }
      } */

    /**
     * Obtiene la URL del archivo devuelta por el servicio de almacenamiento
     * @param string $file Es la ruta relativa del archivo, ejemplo: <pre>"images/file1.txt"</pre>
     * @return string
     */
    public function getUrl($file) {
        switch ($this->service) {
            case self::AWS_S3:
                return $this->clientService->getObjectUrl($this->bucket, $file);
            case self::AZURE_BLOB_STORAGE:
                $listBlobsOptions = new ListBlobsOptions();
                $listBlobsOptions->setPrefix($file);
                $blob_list = $this->clientService->listBlobs($this->bucket, $listBlobsOptions);
                $blobs = $blob_list->getBlobs();

                foreach ($blobs as $blob) {
                    return $blob->getUrl();
                }
            case self::GOOGLE_CLOUD_STORAGE:
                return $this->clientService->bucket($this->bucket)->object($file)->signedUrl(new Timestamp(new DateTime('tomorrow')));
            case self::LOCAL:
            // Predefinido.
            default:
                $url = \Yii::$app->urlManager->baseUrl ."/" . $file;                
                return $url;
        }
    }

    /**
     * Sube el archivo a Azure Blob Storage
     * @param \yii\web\UploadedFile $file
     * @throws HttpException
     */
    private function uploadToAzure($file) {
        try {
            $blob_content = file_get_contents($file->tempName);
            $blockBlobOptions = new CreateBlockBlobOptions();
            $blockBlobOptions->setContentType($file->type);
            $this->clientService->createBlockBlob($this->bucket, $this->prefix . $file->name, $blob_content, $blockBlobOptions);
        } catch (AzureStorageException $ex) {
            throw new HttpException($ex->getCode(), $ex->getMessage());
        }
    }

    /**
     * Sube el archivo a Amazon S3
     * @param \yii\web\UploadedFile $file
     * @throws HttpException
     */
    private function uploadToS3($file) {
        try {
            $content = file_get_contents($file->tempName);
            $this->clientService->putObject([
                'Bucket' => $this->bucket,
                'Key' => $this->prefix . $file->name,
                'Body' => $content,
                'ACL' => 'public-read']);
        } catch (S3Exception $ex) {
            throw new HttpException($ex->getCode(), $ex->getMessage());
        }
    }

    /**
     * Sube el archivo a Google Cloud Storage
     * @param \yii\web\UploadedFile $file
     * @throws HttpException
     */
    private function uploadToGoogle($file) {
        try {
            $content = file_get_contents($file->tempName);
            $this->clientService->bucket($this->bucket, true)->upload($content, ['name' => $this->prefix . $file->name, 'predefinedAcl' => 'publicRead']);
        } catch (GoogleClodStorageException $ex) {
            throw new HttpException($ex->getCode(), $ex->getMessage());
        }
    }

    /**
     * Sube el archivo al servidor web.
     * @param \yii\web\UploadedFile $file
     * @throws HttpException
     */
    private function uploadToLocal($file) {
        try {
            $file->saveAs(\Yii::getAlias($this->bucket . $this->prefix) . $file->name);
        } catch (\Exception $ex) {
            throw new HttpException(500, $ex->getMessage());
        }
    }

}
