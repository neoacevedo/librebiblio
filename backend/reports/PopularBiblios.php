<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
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
class PopularBiblios extends \yii\db\ActiveRecord {

    public $name = "Most Popular Bibliographies";
    public $category = "Statistics";

    /**
     * @inheritdoc
     */
    public static function tableName() {
        if (Yii::$app->request->queryParams['groupBy'] === 'biblio') {
            return '{{%popular_biblios_by_id}}';
        } elseif (Yii::$app->request->queryParams['groupBy'] === 'copy') {
            return '{{%popular_biblios_by_barcode}}';
        }
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'checkoutCount'], 'integer'],
            [['title', 'author'], 'string'],
            [['barcode_nmbr'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
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
    public static function primaryKey() {
        parent::primaryKey();
        return ['id'];
    }

    /**
     * Devuelve el nombre del reporte traducido.
     * @return string
     */
    public function getName() {
        return Yii::t("app/reports", $this->name);
    }

    /**
     * Devuelve el nombre de la categoría traducida.
     * @return string
     */
    public function getCategory() {
        return Yii::t("app/reports", $this->category);
    }

}
