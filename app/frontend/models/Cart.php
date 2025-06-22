<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property int $id
 * @property int $bibid
 * @property int $copyid
 * @property int $mbr_id
 * @property string $status
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bibid', 'copyid', 'status'], 'required'],
            [['bibid', 'copyid', 'mbr_id'], 'integer'],
            [['status'], 'string', 'max' => 3],
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
            'status' => Yii::t('app', 'Status'),
        ];
    }
    
    /**
     * Obtiene la bibliografía a la que pertenece la copia
     * @return \yii\db\ActiveQuery
     */
    public function getBiblio() {
        return $this->hasOne(\common\models\Biblio::class, ['id' => 'bibid']);
    }
    
    /**
     * Obtiene la bibliografía a la que pertenece la copia
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioCopy() {
        return $this->hasOne(\common\models\BiblioCopy::class, ['id' => 'copyid']);
    }
}
