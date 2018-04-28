<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%usmarc_block_dm}}".
 *
 * @property int $block_mbr
 * @property string $description
 */
class Usmarc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%usmarc_block_dm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['block_mbr', 'description'], 'required'],
            [['block_mbr'], 'integer'],
            [['description'], 'string', 'max' => 80],
            [['block_mbr'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'block_mbr' => Yii::t('usmarc', 'Block Mbr'),
            'description' => Yii::t('usmarc', 'Description'),
        ];
    }
}
