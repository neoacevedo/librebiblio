<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace backend\reports;

use Yii;

/**
 * This is the model class for table "{{%checkoutStats}}".
 *
 * @property int $id
 * @property string $created_at
 * @property int $checkoutCount
 */
class CheckoutStats extends \yii\db\ActiveRecord {

    public $name = "Periodic Checkout Count";
    public $category = "Statistics";

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%checkoutStats}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'checkoutCount'], 'integer'],
            [['created_at'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app/reports', 'ID'),
            'created_at' => Yii::t('app/reports', 'Cycle'),
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
