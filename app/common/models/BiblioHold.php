<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
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
            [['mbr_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::class, 'targetAttribute' => ['mbr_id' => 'id']],
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
     * Obtiene la bibliografía de la copia bibliográfica 
     * @return \yii\db\ActiveQuery
     */
    public function getBiblio()
    {
        return $this->hasOne(Biblio::class, ['id' => 'bibid']);
    }
    
    /**
     * Obtiene la copia bibliográfica que está reservada.
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioCopy()
    {
        return $this->hasOne(BiblioCopy::class, ['id' => 'copyid']);
    }

    /**
     * Obtiene el miembro de la biblioteca que reservó la copia.
     * @return \yii\db\ActiveQuery
     */
    public function getMbr()
    {
        return $this->hasOne(Member::class, ['id' => 'mbr_id']);
    }
}
