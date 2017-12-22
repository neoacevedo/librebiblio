<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%theme}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frontend
 * @property integer $active
 * @property string $created_at
 */
class Theme extends \yii\db\ActiveRecord
{
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
            [['name'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/theme', 'ID'),
            'name' => Yii::t('app/theme', 'Name'),
            'frontend' => Yii::t('app/theme', 'Frontend'),
            'active' => Yii::t('app/theme', 'Active'),
            'created_at' => Yii::t('app/theme', 'Created At'),
        ];
    }
}
