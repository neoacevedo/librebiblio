<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%biblio_field}}".
 *
 * @property integer $bibid
 * @property integer $fieldid
 * @property integer $tag
 * @property string $ind1_cd
 * @property string $ind2_cd
 * @property string $subfield_cd
 * @property string $field_data
 *
 * @property Biblio $biblio
 */
class BiblioField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%biblio_field}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bibid', 'tag', 'subfield_cd'], 'required'],
            [['bibid', 'tag'], 'integer'],
            [['field_data'], 'string', 'skipOnEmpty' => true],
            [['ind1_cd', 'ind2_cd', 'subfield_cd'], 'string', 'max' => 1],
            [['bibid'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Biblio::class, 'targetAttribute' => ['bibid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bibid' => Yii::t('app', 'Bibid'),
            'fieldid' => Yii::t('app', 'Fieldid'),
            'tag' => Yii::t('app', 'Tag'),
            'ind1_cd' => Yii::t('cataloging', 'Ind1 Cd'),
            'ind2_cd' => Yii::t('cataloging', 'Ind2 Cd'),
            'subfield_cd' => Yii::t('cataloging', 'Subfield Cd'),
            'field_data' => Yii::t('cataloging', 'Field Data'),
        ];
    }

    /**
     * Devuelve la bibliografía a la que pertenece el campo.
     * @return \yii\db\ActiveQuery
     */
    public function getBiblio()
    {
        return $this->hasOne(Biblio::class, ['id' => 'bibid']);
    }
}
