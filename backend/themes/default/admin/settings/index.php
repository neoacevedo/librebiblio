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
                ['label' => Yii::t('app/settings', 'Material Types'), 'url' => ['admin/material-type/index'], 'icon' => 'tags'],
                ['label' => Yii::t('app/settings', 'Collections'), 'url' => ['admin/collections/index'], 'icon' => 'folder-open'],
                ['label' => Yii::t('app/settings', 'Member Classify'), 'url' => ['admin/member-classify/index'], 'icon' => 'user'],
                ['label' => Yii::t('app/settings', 'Checkout Privileges'), 'url' => ['admin/checkout-privs/index'], 'icon' => 'check'],
                ['label' => Yii::t('app/settings', 'Themes'), 'url' => ['admin/themes'], 'icon' => 'adjust']
            ],
        ]);
        ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <div class="content">
            <h4><?= Html::encode(Yii::t('app/settings', 'Library Settings')) ?></h4>
            <p><?= Html::encode(Yii::t('app/settings', 'Basic Library Settings.')) ?></p>
            <h4><?= Html::encode(Yii::t('app/settings', 'Material Types')) ?></h4>
            <p><?= Html::encode(Yii::t('app/settings', 'Add/Edit/Delete Material types for Library.')) ?></p>
            <h4><?= Html::encode(Yii::t('app/settings', 'Collections')) ?></h4>
            <p><?= Html::encode(Yii::t('app/settings', 'Add/Edit/Delete Bibliograhical Collections.')) ?></p>
            <h4><?= Html::encode(Yii::t('app/settings', 'Member Classify')) ?></h4>
            <p><?= Html::encode(Yii::t('app/settings', 'Add/Edit/Delete Classification for Library Members.')) ?></p>
            <h4><?= Html::encode(Yii::t('app/settings', 'Checkout Privileges')) ?></h4>
            <p><?= Html::encode(Yii::t('app/settings', 'Add/Edit/Delete Checkout for Library Members.')) ?></p>
            <h4><?= Html::encode(Yii::t('app/settings', 'Themes')) ?></h4>
            <p><?= Html::encode(Yii::t('app/settings', 'Add/Edit/Delete Themes.')) ?></p>
        </div>
    </div>
</div>