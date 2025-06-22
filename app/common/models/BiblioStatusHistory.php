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
 * This is the model class for table "{{%biblio_status_hist}}".
 *
 * @property integer $id
 * @property integer $bibid
 * @property integer $copyid
 * @property string $status_cd
 * @property string $created_at
 * @property string $updated_at
 * @property string $due_back_dt
 * @property integer $mbr_id
 *
 * @property Biblio $biblio
 * @property BiblioCopy $biblioCopy
 * @property Member $member
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
            [['mbr_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::class, 'targetAttribute' => ['mbr_id' => 'id']],
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

    /**
     * Obtiene el miembro de la biblioteca en el historial
     * @return Yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::class, ['id' => 'mbr_id']);
    }
}
