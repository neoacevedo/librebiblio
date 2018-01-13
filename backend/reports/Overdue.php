<?php

namespace backend\reports;

use Yii;

/**
 * This is the model class for table "{{%overdue}}".
 *
 * @property integer $bibid
 * @property integer $id
 * @property integer $mbr_id
 * @property string $barcode_nmbr
 * @property string $callno
 * @property string $title
 * @property string $author
 * @property string $status_begin_dt
 * @property string $due_back_dt
 * @property string $full_name
 * @property integer $days_late
 */
class Overdue extends \yii\db\ActiveRecord
{
    public $name = "Over Due Member List";
    public $category = "Circulation";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%overdue}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bibid', 'id', 'mbr_id', 'days_late'], 'integer'],
            [['title', 'author'], 'string'],
            [['status_begin_dt', 'due_back_dt'], 'safe'],
            [['barcode_nmbr'], 'string', 'max' => 20],
            [['callno'], 'string', 'max' => 62],
            [['full_name'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bibid' => Yii::t('app', 'Bibid'),
            'id' => Yii::t('app', 'ID'),
            'mbr_id' => Yii::t('app', 'Member ID'),
            'barcode_nmbr' => Yii::t('app', 'Barcode Nmbr'),
            'callno' => Yii::t('app/reports', 'Callno'),
            'title' => Yii::t('app', 'Title'),
            'author' => Yii::t('app', 'Author'),
            'status_begin_dt' => Yii::t('app', 'Status Begin Dt'),
            'due_back_dt' => Yii::t('app', 'Due Back Dt'),
            'full_name' => Yii::t('app', 'Name'),
            'days_late' => Yii::t('app', 'Days Late'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function primaryKey() {
        parent::primaryKey();
        return ['id'];
    }
}
