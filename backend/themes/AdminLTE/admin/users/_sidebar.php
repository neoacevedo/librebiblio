<?php
use kartik\sidenav\SideNav;
?>
<div class="col-lg-3 col-md-3 col-sm-3">
    <?php
    if (YII_ENV_DEV) {
        echo SideNav::widget([
            'type' => SideNav::TYPE_PRIMARY,
            'heading' => Yii::t('app', 'Options'),
            'headingOptions' => ['class' => 'head-style'],
            'items' => [['label' => Yii::t('app', 'Create User'), 'url' => ['admin/users-create'], 'type' => 'link'],
                ['label' => Yii::t('app', 'Roles'), 'url' => ['admin/users/role']],
                ['label' => Yii::t('app', 'Rules'), 'url' => ['admin/users/rule']],
                ['label' => Yii::t('app', 'Permissions'), 'url' => ['admin/users/permission']],
                ['label' => Yii::t('app', 'Assignment'), 'url' => ['admin/users/assignment']]],
        ]);
    } else {
        echo SideNav::widget([
            'type' => SideNav::TYPE_PRIMARY,
            'heading' => Yii::t('app', 'Options'),
            'headingOptions' => ['class' => 'head-style'],
            'items' => [['label' => Yii::t('app', 'Create User'), 'url' => ['admin/users-create'], 'type' => 'link'],
                ['label' => Yii::t('app', 'Roles'), 'url' => ['admin/users/role']],
                ['label' => Yii::t('app', 'Assignment'), 'url' => ['admin/users/assignment']]],
        ]);
    }
    ?>
</div>