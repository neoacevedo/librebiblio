<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
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
    public $name = "Copy Search";
    public $category = "Cataloging";
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
            'barcode_nmbr' => Yii::t('app', 'Barcode Nmbr'),
            'callno' => Yii::t('app/reports', 'Callno'),
            'title' => Yii::t('app', 'Title'),
            'author' => Yii::t('app', 'Author'),
            'collection' => Yii::t('app', 'Collection'),
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
