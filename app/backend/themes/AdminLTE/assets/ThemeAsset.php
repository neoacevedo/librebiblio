<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\themes\AdminLTE\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Summary of ThemeAsset
 */
class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/AdminLTE/assets/src';

    public $css = [
        'css/adminlte.min.css',
        'css/bootstrap-icons.min.css',
        'css/custom.min.css',
    ];
    public $js = [
        'js/adminlte.min.js',
        YII_DEBUG ? 'js/customize.js' : 'js/customize.min.js'
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => \yii\web\View::POS_END,
    ];

    /**
     * @inheritDoc
     */
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
