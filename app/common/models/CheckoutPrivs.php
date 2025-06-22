<?php
/**
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace common\models;

use Yii;
use common\models\MemberClassify;
use common\models\MaterialType;

/**
 * This is the model class for table "{{%checkout_privs}}".
 *
 * @property integer $id
 * @property integer $material_cd
 * @property integer $classification_id
 * @property integer $checkout_limit
 * @property integer $renewal_limit
 *
 * @property MemberClassify $memberClassify
 * @property MaterialType $materialCd
 */
class CheckoutPrivs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%checkout_privs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_cd', 'classification_id', 'checkout_limit', 'renewal_limit'], 'required'],
            [['material_cd', 'classification_id', 'checkout_limit', 'renewal_limit'], 'integer'],
            [['classification_id'], 'exist', 'skipOnError' => true, 'targetClass' => MemberClassify::class, 'targetAttribute' => ['classification_id' => 'id']],
            [['material_cd'], 'exist', 'skipOnError' => true, 'targetClass' => MaterialType::class, 'targetAttribute' => ['material_cd' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('checkout', 'ID'),
            'material_cd' => Yii::t('checkout', 'Material Cd'),
            'classification_id' => Yii::t('checkout', 'Classification ID'),
            'checkout_limit' => Yii::t('checkout', 'Checkout Limit'),
            'renewal_limit' => Yii::t('checkout', 'Renewal Limit'),
        ];
    }

    /**
     * Obtiene el tipo de miembro (su clasificación en la biblioteca)
     * @return \yii\db\ActiveQuery
     */
    public function getMemberClassify()
    {
        return $this->hasOne(MemberClassify::class, ['id' => 'classification_id']);
    }

    /**
     * Obtiene el tipo de material
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialType()
    {
        return $this->hasOne(MaterialType::class, ['id' => 'material_cd']);
    }
}
