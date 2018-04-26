<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
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
    public $name = "Bibliography Checkout Listing";
    public $category = "Circulation";
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
