<?php

namespace backend\components;

use Yii;

/**
 * @inheritdoc
 */
class Theme extends \yii\base\Theme
{
    /**
     * Theme folder name
     *
     * @var string
     */
    public $theme = 'AdminLTE';

    /** @var mixed */
    public $settings;

    /** @var int */
    public $id;

    public function init()
    {
        parent::init();

        $theme = \common\models\Theme::find()->where(['active' => 1, 'frontend' => 0])->one();
        if (!$theme) {
            $this->theme = 'default';
        } else {
            $this->theme = $theme->name;
        }

        $this->basePath = $this->theme == 'default' ? '@app/themes/' . $this->theme : $theme->sourcePath;
        $this->baseUrl = '@web/themes/' . strtolower($this->theme);
        $this->pathMap = [
            '@app/views' => $this->theme == 'default' ? '@app/themes/' . $this->theme . "/views" : $theme->sourcePath . "/views",
        ];

        $this->settings = (array) json_decode($theme->settings);
        $this->id = $theme->id;
    }
}
