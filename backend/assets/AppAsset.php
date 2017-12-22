<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    
    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $theme = \common\models\Theme::find()->where(['active' => 1, 'frontend' => 0])->one();
        $css_files = \yii\helpers\FileHelper::findFiles("{$this->basePath}/themes/{$theme->name}/css/");
        $css_files = str_replace("{$this->basePath}/themes/{$theme->name}/css/", "{$this->baseUrl}/themes/{$theme->name}/css/", $css_files);
        $this->css = array_merge($this->css, $css_files);
    }

}
