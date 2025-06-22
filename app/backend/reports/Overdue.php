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

namespace backend\reports;

use Yii;

/**
 * This is the model class for table "{{%overdue}}".
 *
 * @property integer $bibid
 * @property integer $id
 * @property integer $mbr_id
 * @property string $barcode_nmbr
 * @property string $callno
 * @property string $title
 * @property string $author
 * @property string $status_begin_dt
 * @property string $due_back_dt
 * @property string $full_name
 * @property integer $days_late
 */
class Overdue extends \yii\db\ActiveRecord
{
    private static $name = "Over Due Member List";
    private static $category = "Circulation";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%overdue}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bibid', 'id', 'mbr_id', 'days_late'], 'integer'],
            [['title', 'author'], 'string'],
            [['status_begin_dt', 'due_back_dt'], 'safe'],
            [['barcode_nmbr'], 'string', 'max' => 20],
            [['callno'], 'string', 'max' => 62],
            [['full_name'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bibid' => Yii::t('app', 'Bibid'),
            'id' => Yii::t('app', 'ID'),
            'mbr_id' => Yii::t('app', 'Member ID'),
            'barcode_nmbr' => Yii::t('biblio', 'Barcode Nmbr'),
            'callno' => Yii::t('app/reports', 'Callno'),
            'title' => Yii::t('app', 'Title'),
            'author' => Yii::t('app', 'Author'),
            'status_begin_dt' => Yii::t('app', 'Status Begin Dt'),
            'due_back_dt' => Yii::t('app', 'Due Back Dt'),
            'full_name' => Yii::t('app', 'Name'),
            'days_late' => Yii::t('app', 'Days Late'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        parent::primaryKey();
        return ['id'];
    }

    /**
     * Devuelve el nombre del reporte traducido.
     * @return string
     */
    public static function getName()
    {
        return Yii::t("app/reports", self::$name);
    }

    /**
     * Devuelve el nombre de la categoría traducida.
     * @return string
     */
    public static function getCategory()
    {
        return Yii::t("app/reports", self::$category);
    }
}
