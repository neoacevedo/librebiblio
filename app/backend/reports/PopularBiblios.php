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
 * This is the model class for table "{{%popular_biblios}}".
 *
 * @property integer $id
 * @property string $barcode_nmbr
 * @property string $title
 * @property string $author
 * @property integer $checkoutCount
 */
class PopularBiblios extends \yii\db\ActiveRecord
{

    private static $name = "Most Popular Bibliographies";
    private static $category = "Statistics";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        if (Yii::$app->request->queryParams['groupBy'] === 'biblio') {
            return '{{%popular_biblios_by_id}}';
        } elseif (Yii::$app->request->queryParams['groupBy'] === 'copy') {
            return '{{%popular_biblios_by_barcode}}';
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'checkoutCount'], 'integer'],
            [['title', 'author'], 'string'],
            [['barcode_nmbr'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'barcode_nmbr' => Yii::t('biblio', 'Barcode Nmbr'),
            'title' => Yii::t('app', 'Title'),
            'author' => Yii::t('app', 'Author'),
            'checkoutCount' => Yii::t('app/reports', 'Checkout Count'),
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
