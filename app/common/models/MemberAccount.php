<?php
/**
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
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
     * Devuelve el usuario que modificó la información de la cuenta.
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\backend\models\User::class, ['id' => 'create_userid']);
    }

}
