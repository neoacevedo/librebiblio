<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%usmarc_subfield_dm}}".
 *
 * @property integer $tag
 * @property string $subfield_cd
 * @property string $description
 * @property string $repeatable_flg
 */
class UsmarcSubfield extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%usmarc_subfield_dm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag', 'subfield_cd', 'description', 'repeatable_flg'], 'required'],
            [['tag'], 'integer'],
            [['subfield_cd', 'repeatable_flg'], 'string', 'max' => 1],
            [['description'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag' => Yii::t('app', 'Tag'),
            'subfield_cd' => Yii::t('app', 'Subfield Cd'),
            'description' => Yii::t('app', 'Description'),
            'repeatable_flg' => Yii::t('app', 'Repeatable Flg'),
        ];
    }
}
