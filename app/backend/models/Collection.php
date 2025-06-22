<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace backend\models;

use Yii;
use common\models\Biblio;

/**
 * This is the model class for table "{{%collection_dm}}".
 *
 * @property integer $id
 * @property string $description
 * @property string $default_flg
 * @property integer $days_due_back
 * @property string $dayli_late_fee
 *
 * @property Biblio[] $biblios
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%collection_dm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'default_flg', 'days_due_back', 'daily_late_fee'], 'required'],
            [['days_due_back'], 'integer'],
            [['daily_late_fee'], 'number'],
            [['description'], 'string', 'max' => 40],
            [['default_flg'], 'string', 'max' => 1],
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
            'days_due_back' => Yii::t('app', 'Days Due Back'),
            'daily_late_fee' => Yii::t('app', 'Daily Late Fee'),
        ];
    }

    /**
     * Devuelve la lista de colecciones como un array
     * @return array
     */
    public static function asArray(): array
    {
        $collections = Collection::find()->select('id, description')->asArray()->all();
        foreach ($collections as $index => $value) {
            $collection[$value['id']] = $value['description'];
        }

        return $collection;
    }

    /**
     * Devuelve las bibliografías asociadas con la colección
     * @return \yii\db\ActiveQuery
     */
    public function getBiblios()
    {
        return $this->hasMany(Biblio::class, ['collection_cd' => 'id']);
    }
}
