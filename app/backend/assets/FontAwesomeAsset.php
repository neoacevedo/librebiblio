<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@npm/fontawesome-free';
    public $css = [
        'css/all.min.css',
    ];
    public $js = [
    ];
}
