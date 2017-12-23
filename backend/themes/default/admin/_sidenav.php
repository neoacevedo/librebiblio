<?php

use kartik\sidenav\SideNav;

echo SideNav::widget([
    'type' => SideNav::TYPE_DEFAULT,
    'heading' => Yii::t('app', 'Options'),
    'headingOptions' => ['class' => 'head-style'],
    'items' => [
        ['label' => Yii::t('app/settings', 'Library Settings'), 'url' => ['admin/settings/library-settings'], 'icon' => 'wrench'],
        ['label' => Yii::t('app/settings', 'Material Types'), 'url' => ['admin/material-type/index'], 'icon' => 'tags'],
        ['label' => Yii::t('app/settings', 'Collections'), 'url' => ['admin/collections/index'], 'icon' => 'folder-open'],
        ['label' => Yii::t('app/settings', 'Member Classify'), 'url' => ['admin/member-classify/index'], 'icon' => 'user'],
        ['label' => Yii::t('app/settings', 'Checkout Privileges'), 'url' => ['admin/checkout-privs/index'], 'icon' => 'check'],
        ['label' => Yii::t('app/settings', 'Themes'), 'url' => ['admin/theme/index'], 'icon' => 'adjust']
    ],
]);

