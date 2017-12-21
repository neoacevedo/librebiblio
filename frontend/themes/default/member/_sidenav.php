<?php

use kartik\sidenav\SideNav;

echo SideNav::widget([
    'type' => SideNav::TYPE_DEFAULT,
    'heading' => Yii::t('app', 'Circulation'),
    'items' => [
        ['label' => Yii::t('app', 'Account'), 'url' => ['member/account']],
        ['label' => Yii::t('app', 'New Member'), 'url' => ['circulation/member-create']],
        ['label' => Yii::t('app', 'Check in'), 'url' => ['circulation/checkin']]
    ]
]);
