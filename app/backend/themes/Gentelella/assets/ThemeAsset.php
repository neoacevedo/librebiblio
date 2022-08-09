<?php
/**
 * @copyright Copyright (c) 2015 Yiister
 * @license https://github.com/yiister/yii2-gentelella/blob/master/LICENSE
 * @link http://gentelella.yiister.ru
 */

namespace backend\themes\Gentelella\assets;

use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle
{
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
        'backend\themes\Gentelella\assets\BootstrapProgressbar',
        'backend\themes\Gentelella\assets\ThemeProductionAsset',
        'backend\themes\Gentelella\assets\ThemeBuildAsset',
        'backend\themes\Gentelella\assets\ThemeSrcAsset',
    ];
}
