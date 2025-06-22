<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle
{
    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];

    public function init()
    {
        parent::init();
        /** @var \common\models\Theme $theme */
        $theme = \common\models\Theme::find()->where(['active' => 1, 'frontend' => 0])->one();

        // $this->sourcePath = Yii::getAlias("@app/themes/{$theme->name}/assets");
        $this->sourcePath = Yii::getAlias($theme->sourcePath . "/assets");

        $css_files = [];
        $js_files = [];

        if (file_exists($this->sourcePath . "/css")) {
            $css_files = \yii\helpers\FileHelper::findFiles($this->sourcePath . "/css", ['only' => ['*.min.css']]);
            $css_files = str_replace($this->sourcePath . "/css", "css", $css_files);
            natsort($css_files);
        }

        if (file_exists($this->sourcePath . "/js")) {
            $js_files = \yii\helpers\FileHelper::findFiles($this->sourcePath . "/js", ['only' => ['*.min.js'], 'except' => ['customize.js', 'custom.js', 'demo.js']]);
            $js_files = str_replace($this->sourcePath . "/js", "js", $js_files);
            natsort($js_files);
        }

        $this->css = $css_files;
        $this->js = $js_files;
    }

    /**
     * Registers this asset bundle with a view.
     * @param \yii\web\View $view the view to be registered with
     * @return static the registered asset bundle instance
     */
    public static function register($view)
    {
        return parent::register($view);
    }
}
