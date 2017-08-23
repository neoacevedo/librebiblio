<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property string $library_name
 * @property string $library_image_url
 * @property string $use_image_flg
 * @property string $library_hours
 * @property string $lirbrary_phone
 * @property integer $session_timeout
 * @property integer $purge_history_after_months
 * @property string $block_checkouts_when_fines_due
 * @property integer $hold_max_days
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['library_hours', 'purge_history_after_months', 'block_checkouts_when_fines_due', 'hold_max_days'], 'required'],
            [['purge_history_after_months', 'hold_max_days'], 'integer'],
            [['library_name', 'library_hours'], 'string', 'max' => 128],
            [['library_image_url'], 'string', 'max' => 255],
            [['use_image_flg', 'block_checkouts_when_fines_due'], 'string', 'max' => 1],
            [['library_phone'], 'string', 'max' => 49],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'library_name' => Yii::t('app', 'Library Name'),
            'library_image_url' => Yii::t('app', 'Library Image Url'),
            'use_image_flg' => Yii::t('app', 'Use Image Flg'),
            'library_hours' => Yii::t('app', 'Library Hours'),
            'lirbrary_phone' => Yii::t('app', 'Lirbrary Phone'),
            'purge_history_after_months' => Yii::t('app', 'Purge History After Months'),
            'block_checkouts_when_fines_due' => Yii::t('app', 'Block Checkouts When Fines Due'),
            'hold_max_days' => Yii::t('app', 'Hold Max Days'),
        ];
    }
}
