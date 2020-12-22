<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%theme}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frontend
 * @property integer $active
 * @property string $skin 
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
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frontend', 'active'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'skin'], 'string', 'max' => 15],
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
            'active' => Yii::t('app', 'Active'),
            'skin' => Yii::t('app/theme', 'Skin'),
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
            $path = Yii::$app->basePath;
            $this->name = $this->themeFile->baseName;
            $this->themeFile->saveAs("$path/tmp/" . $this->themeFile->name, false);
            return true;
        } else {
            return false;
        }
    }
}
