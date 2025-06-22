<?php

use kartik\sidenav\SideNav;

echo SideNav::widget([
    'type' => SideNav::TYPE_DEFAULT,
    'heading' => Yii::t('app', 'Circulation'),
    'items' => [
        ['label' => Yii::t('app', 'Home'), 'url' => ['circulation/index']],
        ['label' => Yii::t('app', 'New Member'), 'url' => ['member/create']],
        ['label' => Yii::t('app', 'Check in'), 'url' => ['circulation/checkin']]
    ]
]);
