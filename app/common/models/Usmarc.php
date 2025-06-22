<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%usmarc_block_dm}}".
 *
 * @property int $block_mbr
 * @property string $description
 *
 * @property UsmarcTagDm[] $usmarcTags
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

    /**
     * Gets query for [[UsmarcTagDm]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsmarcTags()
    {
        return $this->hasMany(UsmarcTagDm::class, ['block_nmbr' => 'block_mbr']);
    }
}
