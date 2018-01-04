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
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\YiiAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $theme = \common\models\Theme::find()->where(['active' => 1, 'frontend' => 0])->one();
        if ($theme) {
            // CSS
            try {
                $css_files = \yii\helpers\FileHelper::findFiles("{$this->basePath}/themes/{$theme->name}/css/", ['only' => ['*.min.css'], 'except' => ['skin-*']]);
                $css_files = str_replace("{$this->basePath}/themes/{$theme->name}/css/", "{$this->baseUrl}/themes/{$theme->name}/css/", $css_files);
                natsort($css_files);
                $this->css = array_merge($this->css, $css_files);
            } catch (\Exception $ex) {
                
            }
            // JS
            try {
                $js_files = \yii\helpers\FileHelper::findFiles("{$this->basePath}/themes/{$theme->name}/js/", ['only' => ['*.min.js']]);
                $js_files = str_replace("{$this->basePath}/themes/{$theme->name}/js/", "{$this->baseUrl}/themes/{$theme->name}/js/", $js_files);
                natsort($js_files);
                $this->js = $js_files;
            } catch (\Exception $ex) {
                
            }
        }
    }

}
