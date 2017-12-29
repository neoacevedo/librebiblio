<?php

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
    
    public $title = "Acquisition";
    public $category = "Cataloging";
    
    /**
     * {@inheritdoc }
     */
    public static function tableName()
    {
        return '{{%acquisitions}}';
    }

    /**
     * {@inheritdoc }
     */
    public function rules()
    {
        return [
            [['id', 'Num of Copies'], 'integer'],
            [['created_at'], 'required'],
            [['created_at'], 'safe'],
            [['title', 'author'], 'string'],
            [['collection', 'Material'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc }
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
     * {@inheritdoc }
     */
    public static function primaryKey() {
        parent::primaryKey();
        return ['id'];
    }
}
