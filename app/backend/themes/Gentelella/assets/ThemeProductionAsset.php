<?php
/**
 * @copyright Copyright (c) 2015 Yiister
 * @license https://github.com/yiister/yii2-gentelella/blob/master/LICENSE
 * @link http://gentelella.yiister.ru
 */

namespace backend\themes\Gentelella\assets;

use yii\web\AssetBundle;

class ThemeProductionAsset extends AssetBundle
{
    public $sourcePath = '@bower/gentelella/production/';

    public $css = [
        'css/maps/jquery-jvectormap-2.0.3.css',
    ];

    public $js = [
        'js/moment/moment.min.js'
    ];
}
