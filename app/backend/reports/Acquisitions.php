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
 * This is the model class for table "{{%acquisitions}}".
 *
 * @property integer $id
 * @property string $Call Num
 * @property string $created_at
 * @property string $title
 * @property string $author
 * @property string $collection
 * @property string $Material
 * @property integer $Num of Copies
 */
class Acquisitions extends \yii\db\ActiveRecord
{

    private static $name = "Acquisition";
    private static $category = "Cataloging";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%acquisitions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Num of Copies'], 'integer'],
            [['created_at'], 'safe'],
            [['title', 'author'], 'string'],
            [['collection', 'Material'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'title' => Yii::t('app', 'Title'),
            'author' => Yii::t('app', 'Author'),
            'collection' => Yii::t('app', 'Collection'),
            'Material' => Yii::t('app', 'Material'),
            'Num of Copies' => Yii::t('app/reports', 'Num Of  Copies'),
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
    public function getName()
    {

        return Yii::t("app/reports", self::$name);
    }

    /**
     * Devuelve el nombre de la categoría traducida.
     * @return string
     */
    public function getCategory()
    {

        return Yii::t("app/reports", self::$category);
    }
}
