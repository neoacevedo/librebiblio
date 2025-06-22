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
 * This is the model class for table "{{%copy_search}}".
 *
 * @property integer $id
 * @property string $created_at 
 * @property string $barcode_nmbr
 * @property string $callno
 * @property string $title
 * @property string $author
 * @property string $collection
 */
class Copy extends \yii\db\ActiveRecord
{
    private static $name = "Copy Search";
    private static $category = "Cataloging";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%copy_search}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['created_at'], 'safe'],
            [['title', 'author'], 'string'],
            [['barcode_nmbr'], 'string', 'max' => 20],
            [['status_cd'], 'string', 'max' => 3],
            [['callno'], 'string', 'max' => 62],
            [['collection'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/reports', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'barcode_nmbr' => Yii::t('biblio', 'Barcode Nmbr'),
            'callno' => Yii::t('app/reports', 'Callno'),
            'title' => Yii::t('app', 'Title'),
            'author' => Yii::t('app', 'Author'),
            'collection' => Yii::t('app', 'Collection'),
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
