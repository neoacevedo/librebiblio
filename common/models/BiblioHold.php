<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%biblio_hold}}".
 *
 * @property integer $id
 * @property integer $bibid
 * @property integer $copyid
 * @property string $hold_begin_dt
 * @property integer $mbr_id
 *
 * @property Member $mbr
 * @property BiblioCopy $biblioCopy
 * @property Biblio $biblio
 */
class BiblioHold extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%biblio_hold}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bibid', 'copyid', 'hold_begin_dt'], 'required'],
            [['bibid', 'copyid', 'mbr_id'], 'integer'],
            [['hold_begin_dt'], 'safe'],
            [['mbr_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::className(), 'targetAttribute' => ['mbr_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bibid' => Yii::t('app', 'Bibid'),
            'copyid' => Yii::t('app', 'Copyid'),
            'hold_begin_dt' => Yii::t('app', 'Hold Begin Dt'),
            'mbr_id' => Yii::t('app', 'Mbr ID'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiblio()
    {
        return $this->hasOne(Biblio::className(), ['id' => 'bibid']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioCopy()
    {
        return $this->hasOne(BiblioCopy::className(), ['id' => 'copyid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMbr()
    {
        return $this->hasOne(Member::className(), ['id' => 'mbr_id']);
    }
}
