<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2022 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace common\models;

use Yii;
use common\models\Biblio;

/**
 * This is the model class for table "{{%material_type_dm}}".
 *
 * @property integer $id
 * @property string $description
 * @property string $default_flg
 * @property string $image_file
 * @property string $icon
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
            [['description', ], 'string', 'max' => 40],
            [['default_flg'], 'string', 'max' => 1],
            [['icon'], 'string', 'max' => 45],
            [['image_file'], 'string', 'max' => 255],
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
            'icon' => Yii::t('app', 'Icon'),
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
     * Devuelve los tipos de material como array.
     * @return array
     */
    public static function asArray(): array
    {
        $materials = MaterialType::find()->select('id, description')->asArray()->all();
        foreach ($materials as $index => $value) {
            $material[$value['id']] = $value['description'];
        }

        return $material;
    }
}
