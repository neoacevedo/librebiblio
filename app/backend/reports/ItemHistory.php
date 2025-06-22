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
 * This is the model class for table "{{%item_history}}".
 *
 * @property int $id
 * @property string $call_num
 * @property string $title
 * @property string $author
 * @property int $mbr_id
 * @property string $member
 * @property string $checkout
 * @property string $due
 */
class ItemHistory extends \yii\db\ActiveRecord
{
    private static $name = "Item Checkout History";
    private static $category = "Circulation";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mbr_id'], 'integer'],
            [['title', 'author'], 'string'],
            [['checkout', 'due'], 'safe'],
            [['call_num'], 'string', 'max' => 62],
            [['member'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/reports', 'ID'),
            'call_num' => Yii::t('app/reports', 'Call Num'),
            'title' => Yii::t('app', 'Title'),
            'author' => Yii::t('app', 'Author'),
            'mbr_id' => Yii::t('app/reports', 'Mbr ID'),
            'member' => Yii::t('app', 'Member'),
            'checkout' => Yii::t('app/reports', 'Checkout'),
            'due' => Yii::t('app/reports', 'Due'),
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
