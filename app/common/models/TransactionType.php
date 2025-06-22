<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%transaction_type_dm}}".
 *
 * @property string $code
 * @property string $description
 * @property string $default_flg
 */
class TransactionType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transaction_type_dm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'description', 'default_flg'], 'required'],
            [['code'], 'string', 'max' => 2],
            [['description'], 'string', 'max' => 40],
            [['default_flg'], 'string', 'max' => 1],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('transaction_type', 'Code'),
            'description' => Yii::t('transaction_type', 'Description'),
            'default_flg' => Yii::t('transaction_type', 'Default Flg'),
        ];
    }
}
