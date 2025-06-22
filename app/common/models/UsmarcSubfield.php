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
 * This is the model class for table "{{%usmarc_subfield_dm}}".
 *
 * @property integer $tag
 * @property string $subfield_cd
 * @property string $description
 * @property string $repeatable_flg
 *
 * @property UsmarcTagDm[] $usmarcTagDm
 */
class UsmarcSubfield extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%usmarc_subfield_dm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag', 'subfield_cd', 'description', 'repeatable_flg'], 'required'],
            [['tag'], 'integer'],
            [['subfield_cd', 'repeatable_flg'], 'string', 'max' => 1],
            [['description'], 'string', 'max' => 80],
            [['tag'], 'exist', 'skipOnError' => false, 'targetClass' => UsmarcTagDm::class, 'targetAttribute' => ['tag' => 'tag']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag' => Yii::t('usmarc', 'Tag'),
            'subfield_cd' => Yii::t('usmarc', 'Subfield Cd'),
            'description' => Yii::t('usmarc', 'Description'),
            'repeatable_flg' => Yii::t('usmarc', 'Repeatable Flg'),
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsmarcTagDm()
    {
        return $this->hasMany(UsmarcTagDm::class, ['tag' => 'tag']);
    }
}
