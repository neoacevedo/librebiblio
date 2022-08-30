<?php

/**
 * @link https://www.neoacevedo.co
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * @license https://www.neoacevedo.co/license
 */

namespace common\models;

use Yii;
use common\models\MaterialType;
use backend\models\Collection;
use common\models\BiblioField;
use neoacevedo\auditing\behaviors\AuditBehavior;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%biblio}}".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $updated_userid
 * @property integer $material_cd
 * @property integer $collection_cd
 * @property string|null $call_nmbr1
 * @property string|null $call_nmbr2
 * @property string|null $call_nmbr3
 * @property string|null $title
 * @property string|null $title_remainder
 * @property string|null $image_file
 * @property string|null $responsibility_stmt
 * @property string|null $author
 * @property string|null $topic1
 * @property string|null $topic2
 * @property string|null $topic3
 * @property string|null $topic4
 * @property string|null $topic5
 * @property string $opac_flg
 *
 * @property BiblioCopy[] $biblioCopies
 * @property BiblioField[] $biblioFields
 * @property BiblioStatusHist[] $biblioStatusHists
 * @property CollectionDm $collectionCd
 * @property MaterialTypeDm $materialCd
 * @property User $updatedUser
 */
class Biblio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%biblio}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuditBehavior::class,
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'updated_userid',
                'updatedByAttribute' => 'updated_userid',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['updated_userid', 'material_cd', 'collection_cd', 'opac_flg'], 'required'],
            [['updated_userid', 'material_cd', 'collection_cd', 'created_at', 'updated_at'], 'integer'],
            [['title', 'title_remainder', 'responsibility_stmt', 'author', 'topic1', 'topic2', 'topic3', 'topic4', 'topic5'], 'string'],
            [['image_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['call_nmbr1', 'call_nmbr2', 'call_nmbr3'], 'string', 'max' => 20],
            [['opac_flg'], 'string', 'max' => 1],
            [['updated_userid'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\User::class, 'targetAttribute' => ['updated_userid' => 'id']],
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
            'author' => Yii::t('app', 'Author'),
            'topic1' => Yii::t('biblio', 'Topic1'),
            'topic2' => Yii::t('biblio', 'Topic2'),
            'topic3' => Yii::t('biblio', 'Topic3'),
            'topic4' => Yii::t('biblio', 'Topic4'),
            'topic5' => Yii::t('biblio', 'Topic5'),
            'opac_flg' => Yii::t('app', 'Opac Flg'),
        ];
    }

    /**
     * Gets query for [[BiblioCopies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioCopies()
    {
        return $this->hasMany(BiblioCopy::class, ['bibid' => 'id']);
    }

    /**
     * Gets query for [[BiblioFields]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioFields()
    {
        return $this->hasMany(BiblioField::class, ['bibid' => 'id']);
    }

    /**
     * Gets query for [[BiblioStatusHists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioStatusHists()
    {
        return $this->hasMany(BiblioStatusHistory::class, ['bibid' => 'id']);
    }

    /**
     * Gets query for [[CollectionCd]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollectionCd()
    {
        return $this->hasOne(Collection::class, ['id' => 'collection_cd']);
    }

    /**
     * Gets query for [[MaterialCd]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialCd()
    {
        return $this->hasOne(MaterialType::class, ['id' => 'material_cd']);
    }

    /**
     * Gets query for [[UpdatedUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedUser()
    {
        return $this->hasOne(User::class, ['id' => 'updated_userid']);
    }
    /**
     * Sube el archivo de imagen.
     * @param \yii\web\UploadedFile $imageFile
     * @return boolean
     */
    public function upload($imageFile)
    {
        if (null !== $imageFile) {
            Yii::$app->storage->saveAs($imageFile);
            return true;
        } else {
            return false;
        }
    }
}
