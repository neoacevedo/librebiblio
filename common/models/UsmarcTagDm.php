<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%usmarc_tag_dm}}".
 *
 * @property int $block_nmbr
 * @property int $tag
 * @property string $description
 * @property string $ind1_description
 * @property string $ind2_description
 * @property string $repeatable_flg
 */
class UsmarcTagDm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%usmarc_tag_dm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['block_nmbr', 'tag', 'description', 'ind1_description', 'ind2_description', 'repeatable_flg'], 'required'],
            [['block_nmbr', 'tag'], 'integer'],
            [['description', 'ind1_description', 'ind2_description'], 'string', 'max' => 80],
            [['repeatable_flg'], 'string', 'max' => 1],
            [['block_nmbr', 'tag'], 'unique', 'targetAttribute' => ['block_nmbr', 'tag']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'block_nmbr' => Yii::t('usmarc', 'Block Nmbr'),
            'tag' => Yii::t('usmarc', 'Tag'),
            'description' => Yii::t('usmarc', 'Description'),
            'ind1_description' => Yii::t('usmarc', 'Ind1 Description'),
            'ind2_description' => Yii::t('usmarc', 'Ind2 Description'),
            'repeatable_flg' => Yii::t('usmarc', 'Repeatable Flg'),
        ];
    }
}
