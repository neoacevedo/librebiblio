<?php

use yii\helpers\Html;
use kartik\sidenav\SideNav;

//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BiblioCopySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings">
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?=
        SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => Yii::t('app', 'Options'),
            'headingOptions' => ['class' => 'head-style'],
            'items' => [
                ['label' => Yii::t('app/settings', 'Library Settings'), 'url' => ['admin/settings/library-settings'], 'icon' => 'wrench'],
                ['label' => Yii::t('app/settings', 'Material Types'), 'url' => ['admin/material-type/index']],
                ['label' => Yii::t('app/settings', 'Collections'), 'url' => ['admin/collections/index'], 'icon' => 'duplicate'],
                ['label' => Yii::t('app/settings', 'Themes'), 'url' => ['admin/themes'], 'icon' => 'adjust']
            ],
        ]);
        ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">

    </div>
</div>