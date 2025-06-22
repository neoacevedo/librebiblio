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
 * This is the model class for table "{{%mbr_classify_dm}}".
 *
 * @property integer $id
 * @property string $description
 * @property string $default_flg
 * @property string $max_fines
 *
 * @property CheckoutPrivs[] $checkoutPrivs
 */
class MemberClassify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mbr_classify_dm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'default_flg', 'max_fines'], 'required'],
            [['max_fines'], 'number'],
            [['description'], 'string', 'max' => 40],
            [['default_flg'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
            'default_flg' => Yii::t('app', 'Default Flg'),
            'max_fines' => Yii::t('app', 'Max Fines'),
        ];
    }

    /**
     * Devuelve los privilegios de préstamo de acuerdo a la clasificación del miembro de la biblioteca.
     * @return \yii\db\ActiveQuery
     */
    public function getCheckoutPrivs()
    {
        return $this->hasMany(CheckoutPrivs::class, ['classification_id' => 'id']);
    }

    /**
     * Devuelve los tipos de material como array.
     * @return array
     */
    public static function asArray(): array
    {
        $classifies = MemberClassify::find()->select('id, description')->asArray()->all();
        foreach ($classifies as $index => $value) {
            $classify[$value['description']] = $value['description'];
        }

        return $classify;
    }
}
