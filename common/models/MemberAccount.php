<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%member_account}}".
 *
 * @property integer $id
 * @property integer $mbr_id
 * @property string $created_at
 * @property integer $create_userid
 * @property string $transaction_type_cd
 * @property string $amout
 * @property string $description
 */
class MemberAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member_account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mbr_id', 'created_at', 'create_userid', 'transaction_type_cd', 'amout'], 'required'],
            [['mbr_id', 'create_userid'], 'integer'],
            [['created_at'], 'safe'],
            [['amout'], 'number'],
            [['transaction_type_cd'], 'string', 'max' => 2],
            [['description'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'member_id' => Yii::t('app', 'Mbr ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'create_userid' => Yii::t('app', 'Create Userid'),
            'transaction_type_cd' => Yii::t('app', 'Transaction Type Cd'),
            'amout' => Yii::t('app', 'Amout'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
    
}
