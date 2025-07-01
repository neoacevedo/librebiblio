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

use neoacevedo\auditing\behaviors\AuditBehavior;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%theme}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frontend
 * @property string $sourcePath
 * @property integer $active
 * @property string|null $settings json settings
 * @property string $created_at
 */
class Theme extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $themeFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%theme}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuditBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sourcePath'], 'required'],
            [['frontend', 'active'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 45],
            ['name', 'unique'],
            [['settings'], 'default', 'value' => '{}'],
            [['settings'], 'string'],
            [['sourcePath'], 'default', 'value' => '@app/themes/'],
            [['settings', 'sourcePath'], 'string'],
            [['themeFile'], 'safe'],
            [['themeFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'zip'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'frontend' => Yii::t('app/theme', 'Frontend'),
            'sourcePath' => Yii::t("app/theme", "Source Path"),
            'active' => Yii::t('app', 'Active'),
            'settings' => Yii::t('app/theme', 'Settings'),
            'themeFile' => Yii::t("app", 'File'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Sube un archivo
     * @return boolean
     */
    public function upload()
    {
        if ($this->validate(['themeFile'])) {
            $path = Yii::$app->runtimePath;
            $this->name = $this->themeFile->baseName;
            @mkdir("$path/tmp/", 0775);
            return $this->themeFile->saveAs("$path/tmp/" . $this->themeFile->name, false);
        } else {
            return false;
        }
    }
}
