<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%biblio_copy}}".
 *
 * @property integer $id
 * @property integer $bibid
 * @property string $created_at
 * @property string $updated_at
 * @property string $copy_desc
 * @property string $barcode_nmbr
 * @property string $status_cd
 * @property string $status_begin_dt
 * @property string $due_back_dt
 * @property integer $mbr_id
 * @property integer $renewal_count
 *
 * @property Biblio $bib
 * @property BiblioStatusHist[] $biblioStatusHists
 * @property Biblio[] $bibs
 */
class BiblioCopy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%biblio_copy}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bibid', 'barcode_nmbr', 'status_cd', 'status_begin_dt'], 'required'],
            [['bibid', 'mbr_id', 'renewal_count'], 'integer'],
            [['created_at', 'updated_at', 'status_begin_dt'], 'safe'],
            [['due_back_dt'], 'date', 'format' => 'php:Y-m-d H:i:s', 'skipOnEmpty' => true],
            [['copy_desc'], 'string', 'max' => 160, 'isEmpty' => function($model) { return null; }],
            [['barcode_nmbr'], 'string', 'max' => 20],
            [['status_cd'], 'string', 'max' => 3],
            [['bibid'], 'exist', 'skipOnError' => true, 'targetClass' => Biblio::className(), 'targetAttribute' => ['bibid' => 'id']],
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'copy_desc' => Yii::t('app', 'Copy Desc'),
            'barcode_nmbr' => Yii::t('app', 'Barcode Nmbr'),
            'status_cd' => Yii::t('app', 'Status Cd'),
            'status_begin_dt' => Yii::t('app', 'Status Begin Dt'),
            'due_back_dt' => Yii::t('app', 'Due Back Dt'),
            'mbr_id' => Yii::t('app', 'Mbr ID'),
            'renewal_count' => Yii::t('app', 'Renewal Count'),
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
    public function getBiblioStatusHists()
    {
        return $this->hasMany(BiblioStatusHistory::className(), ['copyid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBibs()
    {
        return $this->hasMany(Biblio::className(), ['id' => 'bibid'])->viaTable('{{%biblio_status_hist}}', ['copyid' => 'id']);
    }
}
