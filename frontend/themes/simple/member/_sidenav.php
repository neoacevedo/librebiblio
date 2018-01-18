<?php

use kartik\sidenav\SideNav;

echo SideNav::widget([
    'type' => SideNav::TYPE_DEFAULT,
    'heading' => $model->username,
    'items' => [
        ['label' => Yii::t("circulation", "Account"), 'url' => ['member/account', 'mbr_id' => $model->id]],
        ['label' => Yii::t('app', 'Update'), 'url' => ['member/update', 'id' => $model->id]],
        ['label' => Yii::t('app', 'History'), 'url' => ['member/history', 'id' => $model->id]],
    ]
]);
