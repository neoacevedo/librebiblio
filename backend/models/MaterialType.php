<?php

namespace backend\models;

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
            [['image_file'], 'string', 'max' => 128],
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
        return $this->hasMany(Biblio::className(), ['material_cd' => 'id']);
    }
}
