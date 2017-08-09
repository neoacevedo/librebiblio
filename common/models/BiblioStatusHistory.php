<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%biblio_status_hist}}".
 *
 * @property integer $bibid
 * @property integer $copyid
 * @property string $status_cd
 * @property string $created_at
 * @property string $updated_at
 * @property string $due_back_dt
 * @property integer $mbr_id
 * @property integer $renewal_count
 *
 * @property Biblio $bib
 * @property BiblioCopy $copy
 * @property User $mbr
 */
class BiblioStatusHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%biblio_status_hist}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bibid', 'copyid', 'status_cd', 'created_at', 'mbr_id'], 'required'],
            [['bibid', 'copyid', 'mbr_id', 'renewal_count'], 'integer'],
            [['created_at', 'updated_at', 'due_back_dt'], 'safe'],
            [['status_cd'], 'string', 'max' => 3],
            [['bibid'], 'exist', 'skipOnError' => true, 'targetClass' => Biblio::className(), 'targetAttribute' => ['bibid' => 'id']],
            [['copyid'], 'exist', 'skipOnError' => true, 'targetClass' => BiblioCopy::className(), 'targetAttribute' => ['copyid' => 'id']],
            [['mbr_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['mbr_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bibid' => Yii::t('app', 'Bibid'),
            'copyid' => Yii::t('app', 'Copyid'),
            'status_cd' => Yii::t('app', 'Status Cd'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'due_back_dt' => Yii::t('app', 'Due Back Dt'),
            'mbr_id' => Yii::t('app', 'Mbr ID'),
            'renewal_count' => Yii::t('app', 'Renewal Count'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBib()
    {
        return $this->hasOne(Biblio::className(), ['id' => 'bibid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCopy()
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
