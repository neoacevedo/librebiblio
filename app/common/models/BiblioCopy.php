<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace common\models;

use neoacevedo\auditing\behaviors\AuditBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%biblio_copy}}".
 *
 * @property integer $id
 * @property string  $barcode_nmbr
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
 * @property Biblio $biblio
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
    public function behaviors()
    {
        return [
            AuditBehavior::class,
            [
                'class' => TimestampBehavior::class,
                'value' => date('Y-m-d H:i:s')
            ],
        ];
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
            [['copy_desc'], 'string', 'max' => 160, 'isEmpty' => function ($model) {
                return null;
            }],
            [['barcode_nmbr'], 'string', 'max' => 20],
            [['status_cd'], 'string', 'max' => 3],
            [['bibid'], 'exist', 'skipOnError' => true, 'targetClass' => Biblio::class, 'targetAttribute' => ['bibid' => 'id']],
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
            'copy_desc' => Yii::t('biblio', 'Copy Desc'),
            'barcode_nmbr' => Yii::t('biblio', 'Barcode Nmbr'),
            'status_cd' => Yii::t('app', 'Status Cd'),
            'status_begin_dt' => Yii::t('app', 'Status Begin Dt'),
            'due_back_dt' => Yii::t('app', 'Due Back Dt'),
            'mbr_id' => Yii::t('app', 'Mbr ID'),
            'renewal_count' => Yii::t('app', 'Renewal Count'),
        ];
    }

    /**
     * Obtiene la bibliografía a la que pertenece la copia
     * @return \yii\db\ActiveQuery
     */
    public function getBiblio()
    {
        return $this->hasOne(Biblio::class, ['id' => 'bibid']);
    }

    /**
     * Devuelve el historial de la copia bibliográfica
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioStatusHist()
    {
        return $this->hasOne(BiblioStatusHistory::class, ['id' => 'copyid']);
    }

    /**
     * Devuelve la relación entre la copia y la bibliografía
     * @return \yii\db\ActiveQuery
     */
    public function getBiblios()
    {
        return $this->hasMany(Biblio::class, ['id' => 'bibid'])->viaTable('{{%biblio_status_hist}}', ['copyid' => 'id']);
    }

    /**
     * Determina si se ha alcanzado el límite de renovación para el miembro dado y el tipo de material
     * @param int $classification_id
     * @return boolean
     */
    public function hasReachedRenewalLimit($classification_id)
    {
        $checkoutPrivs = \common\models\CheckoutPrivs::findOne(['classification_id' => $classification_id, 'material_cd' => $this->biblio->material_cd]);
        if ($checkoutPrivs->renewal_limit == 0) {
            return false; // ilimitado
        }

        if ($this->renewal_count < $checkoutPrivs->renewal_limit) {
            return false; //aún no alcanza el límite de renovaciones
        }

        return true;
    }

    /**
     * Determina si se ha alcanzado el límite de comprobación para el miembro dado y el tipo de material
     * @param int $mbr_id
     * @param int $classification_id
     * @return boolean
     */
    public function hasReachedCheckoutLimit(int $mbr_id, int $classification_id)
    {
        $checkoutPrivs = \common\models\CheckoutPrivs::findOne(['classification_id' => $classification_id, 'material_cd' => $this->biblio->material_cd]);
        if ($checkoutPrivs->checkout_limit == 0) {
            return false; // ilimitado
        }

        $count = (new \yii\db\Query())
            ->select("*")
            ->from('{{%biblio_copy}} c')
            ->leftJoin('{{%biblio}} b', 'c.bibid = b.id')
            ->where(['c.mbr_id' => $mbr_id])
            ->andWhere(['b.material_cd' => $checkoutPrivs->material_cd])
            ->count();

        if ($count >= $checkoutPrivs->checkout_limit) {
            return true; // alcanzó el límite de préstamos
        }

        return false;
    }
}
