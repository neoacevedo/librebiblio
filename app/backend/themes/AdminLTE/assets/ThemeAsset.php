<?php

/**
 * Copyright, Néstor Acevedo (neoacevedo). Todos los derechos reservados.
 */

namespace backend\themes\AdminLTE\assets;

use Yii;
use yii\web\AssetBundle;


/**
 * ThemeAsset is an asset bundle for the AdminLTE theme.
 * 
 * This class manages the inclusion of CSS and JavaScript files required for the AdminLTE theme
 * in the backend of the application. It extends the AssetBundle class provided by the framework.
 *
 * @package backend\themes\AdminLTE\assets
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
