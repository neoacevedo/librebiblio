<?php
/* @var $assetDir string */
$picture = Yii::$app->user->identity->picture ?? "$assetDir/img/user2-160x160.jpg";
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= \yii\helpers\Url::to(['index']) ?>"
        class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png"
            alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= Yii::$app->name ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $picture ?>"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->username ?? "" ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \yii\widgets\Menu::widget([
                'items' => [
                    [
                        'label' => Yii::t("app", "RBAC"),
                        'icon' => 'filter',
                        'items' => [
                            [
                                'label' => Yii::t("rbac", "Permissions Manager"),
                                'icon' => 'check-square',
                                'url' => ['/rbac/permission'],
                            ],
                            [
                                'label' => Yii::t("rbac", "Roles Manager"),
                                'icon' => 'users',
                                'url' => ['/rbac/role'],
                            ],
                            [
                                'label' => Yii::t("rbac", "Rules Manager"),
                                'icon' => 'list',
                                'url' => ['/rbac/rule']
                            ],
                            [
                                'label' => Yii::t("rbac", "Assignment"),
                                'icon' => 'user-plus',
                                'url' => ['/rbac/assignment'],
                            ],
                        ]
                    ],
                    [
                        'label' => Yii::t('app', 'Circulation'), 'url' => ['#'],
                            'options' => ['class' => 'treeview menu'],
                            'template' => '<a href="{url}" ><i class="fa fa-address-book-o"></i><span>{label}</span></a>',
                            'items' => [
                                ['label' => Yii::t('app', 'Home'), 'url' => ['circulation/index']],
                                ['label' => Yii::t('app', 'New Member'), 'url' => ['member/create']],
                                ['label' => Yii::t('app', 'Check in'), 'url' => ['circulation/reception']],
                            ],
                    ],
                    [
                        'label' => Yii::t('app', 'Cataloging'), 'url' => ['#'],
                        'options' => ['class' => 'treeview menu'],
                        'template' => '<a href="{url}" ><i class="fa fa-book"></i><span>{label}</span></a>',
                        'items' => [
                            ['label' => Yii::t('app', 'Home'), 'url' => ['/cataloging/biblio']],
                            ['label' => Yii::t('app', 'Create Biblio'), 'url' => ['/cataloging/biblio/create']],
                        ],
                    ],
                    [
                        'template' => '<a href="{url}" ><i class="fa fa-bar-chart"></i><span>{label}</span></a>',
                        'label' => Yii::t('app/reports', 'Reports'), 'url' => ['admin/report/index'],
                        'items' => [],
                    ],
                    [
                        'label' => Yii::t("app", "Options"),
                        'icon' => 'cogs',
                        'items' => [
                            [
                                'label' => Yii::t('app/settings', 'Library Settings'),
                                'icon' => 'wrench',
                                'url' => ['admin/settings/library-settings'],
                            ],
                            [
                                'label' => Yii::t('app/settings', 'Material Types'),
                                'icon' => 'books',
                                'url' => ['admin/material-type/index'],
                            ],
                            [
                                'label' => Yii::t('app/settings', 'Collections'),
                                'icon' => 'tags',
                                'url' => ['admin/collections/index'],
                            ],
                            [
                                'label' => Yii::t('app/settings', 'Member Classify'),
                                'icon' => 'users',
                                'url' => ['admin/member-classify/index'],
                            ],
                            [
                                'label' => Yii::t('app/settings', 'Checkout Privileges'),
                                'icon' => 'check',
                                'url' => ['admin/checkout-privs/index'],
                            ],
                            [
                                'label' => Yii::t('app/settings', 'Themes'),
                                'icon' => 'check',
                                'url' => ['admin/theme/index'],
                            ],
                            [
                                'label' => Yii::t('app/settings', 'Flush Cache'),
                                'icon' => 'trash',
                                'url' => ['/admin/flush-cache'],
                            ],
                            [
                                'label' => Yii::t('app', 'Help'),
                                'url' => ['/site/help',],
                                'template' => '<a class="nav-link" href="{url}" role="modal-remote" data-toggle="tooltip"><i class="nav-icon fas fa-question-circle"></i> <span>{label}</span></a>'
                            ],
                        ]
                    ],
                    ['label' => 'Yii2 PROVIDED', 'header' => true, 'visible' => YII_DEBUG],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank', 'visible' => YII_DEBUG],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank', 'visible' => YII_DEBUG],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>