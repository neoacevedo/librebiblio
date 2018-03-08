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
 * @property string $amount
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
            [['mbr_id', 'created_at', 'create_userid', 'transaction_type_cd', 'amount'], 'required'],
            [['mbr_id', 'create_userid'], 'integer'],
            [['created_at'], 'safe'],
            [['amount'], 'number'],
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
            'mbr_id' => Yii::t('app', 'Mbr ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'create_userid' => Yii::t('app', 'Create Userid'),
            'transaction_type_cd' => Yii::t('circulation', 'Transaction Type Cd'),
            'amount' => Yii::t('circulation', 'Amount'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
    
    /**
     * Devuelve el ID del usuario que modificó la información del material bibliográfico
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\backend\models\User::className(), ['id' => 'create_userid']);
    }
    
}
