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
