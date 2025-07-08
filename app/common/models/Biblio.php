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

namespace common\models;

use Yii;
use common\models\MaterialType;
use backend\models\User;
use common\models\BiblioField;
use neoacevedo\auditing\behaviors\AuditBehavior;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%biblio}}".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property int $updated_userid
 * @property int $material_cd
 * @property int $collection_cd
 * @property string|null $call_nmbr1 [099 a]
 * @property string|null $call_nmbr2 [099 a]
 * @property string|null $call_nmbr3
 * @property string|null $title [245 a]
 * @property string|null $title_remainder [245 b]
 * @property string|null $image_file
 * @property string|null $responsibility_stmt [245 c]
 * @property string|null $author [100 a]
 * @property string|null $topic1 [650 a]
 * @property string|null $topic2 [650 a1]
 * @property string|null $topic3 [650 a2]
 * @property string|null $topic4 [650 a3]
 * @property string|null $topic5 [650 a4]
 * @property int $opac_flg
 *
 * @property BiblioCopy[] $biblioCopies
 * @property BiblioField[] $biblioFields
 * @property BiblioStatusHistory[] $biblioStatusHists
 * @property Collection $collection
 * @property MaterialType $materialType
 * @property User $user
 */
class Biblio extends ActiveRecord
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
                    static::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    static::EVENT_BEFORE_UPDATE => ['updated_at'],
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
            [['title', 'author', 'material_cd', 'collection_cd', 'opac_flg'], 'required'],
            [['created_at', 'updated_at', 'updated_userid', 'material_cd', 'collection_cd', 'opac_flg'], 'integer'],
            [['title', 'title_remainder', 'responsibility_stmt', 'author', 'topic1', 'topic2', 'topic3', 'topic4', 'topic5'], 'string', 'min' => 1],
            [['call_nmbr1', 'call_nmbr2', 'call_nmbr3'], 'string', 'min' => 1, 'max' => 20],
            [['image_file'], 'string', 'max' => 128],
            [['collection_cd'], 'exist', 'skipOnError' => false, 'targetClass' => Collection::class, 'targetAttribute' => ['collection_cd' => 'id']],
            [['material_cd'], 'exist', 'skipOnError' => false, 'targetClass' => MaterialType::class, 'targetAttribute' => ['material_cd' => 'id']],
            [['updated_userid'], 'exist', 'skipOnError' => false, 'targetClass' => User::class, 'targetAttribute' => ['updated_userid' => 'id']],
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
     * Gets query for [[BiblioStatusHistory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioStatusHistories()
    {
        return $this->hasMany(BiblioStatusHistory::class, ['bibid' => 'id']);
    }

    /**
     * Gets query for [[Collection]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::class, ['id' => 'collection_cd']);
    }

    /**
     * Gets query for [[MaterialType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialType()
    {
        return $this->hasOne(MaterialType::class, ['id' => 'material_cd']);
    }

    /**
     * Gets query for [[UpdatedUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\backend\models\User::class, ['id' => 'updated_userid']);
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
