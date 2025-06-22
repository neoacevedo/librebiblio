<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace common\models;

use neoacevedo\auditing\behaviors\AuditBehavior;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%theme}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frontend
 * @property string $sourcePath
 * @property integer $active
 * @property string|null $settings json settings
 * @property string $created_at
 */
class Theme extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $themeFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%theme}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuditBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sourcePath'], 'required'],
            [['frontend', 'active'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 15],
            [['settings', 'sourcePath'], 'string'],
            [['themeFile'], 'safe'],
            [['themeFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'zip'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'frontend' => Yii::t('app/theme', 'Frontend'),
            'sourcePath' => Yii::t("app/theme", "Source Path"),
            'active' => Yii::t('app', 'Active'),
            'settings' => Yii::t('app/theme', 'Settings'),
            'themeFile' => Yii::t("app", 'File'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Sube un archivo
     * @return boolean
     */
    public function upload()
    {
        if ($this->validate(['themeFile'])) {
            $path = Yii::$app->runtimePath;
            $this->name = $this->themeFile->baseName;
            @mkdir("$path/tmp/", 0775);
            return $this->themeFile->saveAs("$path/tmp/" . $this->themeFile->name, false);
        } else {
            return false;
        }
    }
}
