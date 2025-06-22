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
 * This is the model class for table "{{%checkouts}}".
 *
 * @property int $bibid
 * @property int $id
 * @property int $mbr_id
 * @property string $barcode_nmbr
 * @property string $title
 * @property string $author
 * @property string $status_begin_dt
 * @property string $due_back_dt
 * @property double $pin
 * @property string $member_name
 */
class Checkouts extends \yii\db\ActiveRecord
{
    private static $name = "Bibliography Checkout Listing";
    private static $category = "Circulation";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%checkouts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bibid', 'id', 'mbr_id'], 'integer'],
            [['title', 'author'], 'string'],
            [['status_begin_dt', 'due_back_dt'], 'safe'],
            [['pin'], 'number'],
            [['barcode_nmbr'], 'string', 'max' => 20],
            [['member_name'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bibid' => Yii::t('app/reports', 'Bibid'),
            'id' => Yii::t('app/reports', 'ID'),
            'mbr_id' => Yii::t('app/reports', 'Mbr ID'),
            'barcode_nmbr' => Yii::t('app/reports', 'Barcode Nmbr'),
            'title' => Yii::t('app/reports', 'Title'),
            'author' => Yii::t('app/reports', 'Author'),
            'status_begin_dt' => Yii::t('app', 'Status Begin Dt'),
            'due_back_dt' => Yii::t('app', 'Due Back Dt'),
            'pin' => Yii::t('app/reports', 'Pin'),
            'member_name' => Yii::t('app', 'Member'),
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
