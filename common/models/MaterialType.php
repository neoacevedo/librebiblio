<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%material_type_dm}}".
 *
 * @property integer $id
 * @property string $description
 * @property string $default_flg
 * @property string $image_file
 *
 * @property Biblio[] $biblios
 */
class MaterialType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%material_type_dm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'default_flg'], 'required'],
            [['description'], 'string', 'max' => 40],
            [['default_flg'], 'string', 'max' => 1],
            [['image_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
            'default_flg' => Yii::t('app', 'Default Flg'),
            'image_file' => Yii::t('app', 'Image File'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiblios()
    {
        return $this->hasMany(Biblio::class, ['material_cd' => 'id']);
    }
    
    /**
     * Sube el archivo de imagen.
     * @param yii\web\UploadedFile $imageFile
     * @return boolean
     */
    public function upload($imageFile)
    {
        if (null !== $imageFile) {
            #$this->image_file->saveAs(Yii::getAlias("@frontend")."/web/images/" . $this->image_file->baseName . '.' . $this->image_file->extension);
            Yii::$app->storage->saveAs($imageFile);
            return true;
        } else {
            return false;
        }
    } 
}
