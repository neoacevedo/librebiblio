<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property string $library_name
 * @property string $library_image_url
 * @property string $use_image_flg
 * @property string $library_hours
 * @property string $lirbrary_phone
 * @property integer $session_timeout
 * @property integer $purge_history_after_months
 * @property string $block_checkouts_when_fines_due
 * @property integer $hold_max_days
 * @property integer $offline
 */
class Settings extends \yii\db\ActiveRecord {
    
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['library_hours', 'purge_history_after_months', 'block_checkouts_when_fines_due', 'hold_max_days'], 'required'],
            [['purge_history_after_months', 'hold_max_days', 'offline'], 'integer'],
            [['library_name', 'library_hours'], 'string', 'max' => 128],
            [['library_image_url'], 'string', 'max' => 255],
            [['use_image_flg', 'block_checkouts_when_fines_due', 'offline'], 'string', 'max' => 1],
            [['library_phone'], 'string', 'max' => 49],
            [['imageFile'], 'safe'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * Sobreescribiendo el método primaryKey.
     * @inheritdoc
     * @return mixed
     */
    public static function primaryKey() {
        return ['library_name'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'library_name' => Yii::t('app', 'Library Name'),
            'library_image_url' => Yii::t('app', 'Library Image Url'),
            'use_image_flg' => Yii::t('app', 'Only Show Image in Header'),
            'library_hours' => Yii::t('app', 'Library Hours'),
            'lirbrary_phone' => Yii::t('app', 'Lirbrary Phone'),
            'purge_history_after_months' => Yii::t('app', 'Purge History After Months'),
            'block_checkouts_when_fines_due' => Yii::t('app', 'Block Checkouts When Fines Due'),
            'hold_max_days' => Yii::t('app', 'Hold Max Days'),
            'offline' => Yii::t('app', 'Offline')
        ];
    }
    
    /**
     * Sube un archivo
     * @return boolean
     */
    public function upload()
    {
        if ($this->validate()) {
            $frontend = Yii::getAlias("@frontend");
            $this->imageFile->saveAs("$frontend/web/images/logo/" . $this->imageFile->baseName . '.' . $this->imageFile->extension, false);
            return true;
        } else {
            return false;
        }
    }
}
