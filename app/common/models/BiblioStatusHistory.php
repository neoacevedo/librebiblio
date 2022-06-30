<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
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
 *
 * @property Biblio $bib
 * @property BiblioCopy $copy
 * @property Member $mbr
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
            [['bibid', 'copyid', 'status_cd', 'created_at'], 'required'],
            [['bibid', 'copyid', 'mbr_id'], 'integer'],
            [['created_at', 'updated_at', 'due_back_dt'], 'safe'],
            [['status_cd'], 'string', 'max' => 3],
            [['bibid'], 'exist', 'skipOnError' => true, 'targetClass' => Biblio::class, 'targetAttribute' => ['bibid' => 'id']],
            [['copyid'], 'exist', 'skipOnError' => true, 'targetClass' => BiblioCopy::class, 'targetAttribute' => ['copyid' => 'id']],
            //[['mbr_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::class, 'targetAttribute' => ['mbr_id' => 'id']],
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
        ];
    }

    /**
     * Obtiene la bibliografía de la copia bibliográfica en el historial
     * @return \yii\db\ActiveQuery
     */
    public function getBiblio()
    {
        return $this->hasOne(Biblio::class, ['id' => 'bibid']);
    }

    /**
     * Obtiene la copia bibliográfica en el historial
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioCopy()
    {
        return $this->hasOne(BiblioCopy::class, ['id' => 'copyid']);
    }
}
