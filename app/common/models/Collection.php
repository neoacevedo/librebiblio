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
use common\models\Biblio;

/**
 * This is the model class for table "{{%collection_dm}}".
 *
 * @property integer $id
 * @property string $description
 * @property string $default_flg
 * @property integer $days_due_back
 * @property string $dayli_late_fee
 *
 * @property Biblio[] $biblios
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%collection_dm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'default_flg', 'days_due_back', 'daily_late_fee'], 'required'],
            [['days_due_back'], 'integer'],
            [['daily_late_fee'], 'number'],
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
            'days_due_back' => Yii::t('app', 'Days Due Back'),
            'daily_late_fee' => Yii::t('app', 'Daily Late Fee'),
        ];
    }

    /**
     * Devuelve la lista de colecciones como un array
     * @return array
     */
    public static function asArray(): array
    {
        $collections = Collection::find()->select('id, description')->asArray()->all();
        foreach ($collections as $index => $value) {
            $collection[$value['id']] = $value['description'];
        }

        return $collection;
    }

    /**
     * Devuelve las bibliografías asociadas con la colección
     * @return \yii\db\ActiveQuery
     */
    public function getBiblios()
    {
        return $this->hasMany(Biblio::class, ['collection_cd' => 'id']);
    }
}
