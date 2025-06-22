<?php

use kartik\sidenav\SideNav;

echo SideNav::widget([
    'type' => SideNav::TYPE_DEFAULT,
    'heading' => $model->username,
    'items' => [
        ['label' => Yii::t("circulation", "Profile"), 'url' => "#",
            'items' => [
                ['label' => Yii::t('yii', 'View'), 'url' => 'profile'],
                ['label' => Yii::t('yii', 'Update'), 'url' => ['member/update']],
            ]],
        ['label' => Yii::t("circulation", "Account"), 'url' => ['member/account']],
        ['label' => Yii::t('circulation', 'Place holds'), 'url' => ['member/placeholds']],
        ['label' => Yii::t('app', 'History'), 'url' => ['member/history']],
    ]
]);
