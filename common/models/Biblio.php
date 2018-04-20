<?php
/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2018 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */
namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%biblio}}".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $updated_userid
 * @property integer $material_cd
 * @property integer $collection_cd
 * @property string $image_file 
 * @property string $call_nmbr1
 * @property string $call_nmbr2
 * @property string $call_nmbr3
 * @property string $title
 * @property string $title_remainder
 * @property string $responsibility_stmt
 * @property string $author
 * @property string $topic1
 * @property string $topic2
 * @property string $topic3
 * @property string $topic4
 * @property string $topic5
 * @property string $opac_flg
 *
 * @property User $updatedUser
 */
class Biblio extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%biblio}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['created_at', 'updated_at', 'updated_userid', 'material_cd', 'collection_cd', 'opac_flg'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['updated_userid', 'material_cd', 'collection_cd'], 'integer'],
            [['title', 'title_remainder', 'responsibility_stmt', 'author', 'topic1', 'topic2', 'topic3', 'topic4', 'topic5'], 'string'],
            [['image_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['call_nmbr1', 'call_nmbr2', 'call_nmbr3'], 'string', 'max' => 20],
            [['opac_flg'], 'string', 'max' => 1],
            [['updated_userid'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\User::className(), 'targetAttribute' => ['updated_userid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_userid' => Yii::t('app', 'Updated Userid'),
            'material_cd' => Yii::t('app', 'Material Cd'),
            'collection_cd' => Yii::t('app', 'Collection Cd'),
            'call_nmbr1' => Yii::t('biblio', 'Call Nmbr1'),
            'call_nmbr2' => Yii::t('biblio', 'Call Nmbr2'),
            'call_nmbr3' => Yii::t('biblio', 'Call Nmbr3'),
            'title' => Yii::t('app', 'Title'),
            'title_remainder' => Yii::t('app', 'Title Remainder'),
            'image_file' => Yii::t('app', 'Image File'),
            'responsibility_stmt' => Yii::t('app', 'Responsibility Stmt'),
            'author' => Yii::t('biblio', 'Author'),
            'topic1' => Yii::t('biblio', 'Topic1'),
            'topic2' => Yii::t('biblio', 'Topic2'),
            'topic3' => Yii::t('biblio', 'Topic3'),
            'topic4' => Yii::t('biblio', 'Topic4'),
            'topic5' => Yii::t('biblio', 'Topic5'),
            'opac_flg' => Yii::t('app', 'Opac Flg'),
        ];
    }

    /**
     * Devuelve el ID del usuario que modificó la información del material bibliográfico
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(\backend\models\User::className(), ['id' => 'updated_userid']);
    }

    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialType() {
        return $this->hasOne(\backend\models\MaterialType::className(), ['id' => 'material_cd']);
    }

    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getCollection() {
        return $this->hasOne(\backend\models\Collection::className(), ['id' => 'collection_cd']);
    }

    public function getBiblioFields() {
        return $this->hasMany(\app\models\BiblioField::className(), ['bibid' => 'id']);
    }

    /**
     * Sube el archivo de imagen.
     * @return boolean
     */
    public function upload() {
        if ($this->validate()) {
            if (null !== $this->image_file) {
                #$this->image_file->saveAs(Yii::getAlias("@frontend") . "/web/images/covers/" . $this->image_file->baseName . '.' . $this->image_file->extension);
                Yii::$app->storage->saveAs($this->image_file);
            }
            return true;
        } else {
            return false;
        }
    }

}
