<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%mbr_classify_dm}}".
 *
 * @property integer $id
 * @property string $description
 * @property string $default_flg
 * @property string $max_fines
 *
 * @property CheckoutPrivs[] $checkoutPrivs
 */
class MemberClassify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mbr_classify_dm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'default_flg', 'max_fines'], 'required'],
            [['max_fines'], 'number'],
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
            'max_fines' => Yii::t('app', 'Max Fines'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCheckoutPrivs()
    {
        return $this->hasMany(CheckoutPrivs::className(), ['classification_id' => 'id']);
    }
}
