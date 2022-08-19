<?php
/* @var $assetDir string */

use backend\themes\AdminLTE\widgets\Menu;
use yii\helpers\Url;

$picture = Yii::$app->user->identity->picture ?? "$assetDir/img/user2-160x160.jpg";
?>
<aside class="main-sidebar elevation-4 sidebar-dark-primary">
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

            <?= Menu::widget([
                    "items" => [
                        [
                            "label" => Yii::t("app", "Cataloging"),
                            "icon" => "book",
                            'options' => ['class' => 'nav-header'],
                            'header' => true,
                        ],
                        [
                            "label" => Yii::t("app", "Home"),
                            "url" => ['/cataloging/biblio/index'],
                            "icon" => "check-square"
                        ],
                        [
                            "label" => Yii::t("app", "Create Biblio"),
                            "url" => ["/cataloging/biblio/create"],
                            "icon" => "book"
                        ],
                        [
                            "label" => Yii::t("app", "Biblio Copies"),
                            "url" => ["/biblio-copy/index"],
                            "icon" => "book"
                        ],
                        [
                            "label" => Yii::t("app/reports", "Reports"),
                            "url" => ["/admin/report/index"],
                            "icon" => "chart-bar"
                        ],
                        [
                            "label" => Yii::t("app", "Circulation"),
                            "icon" => "address-book",
                            'options' => ['class' => 'nav-header'],
                            'header' => true,
                        ],
                        [
                            "label" => Yii::t("circulation", "Member Accounts"),
                            "url" => ['/member-account/index'],
                            'icon' => 'users'
                        ],
                        [
                            "label" => Yii::t("app", "Members"),
                            "url" => ['/member/index'],
                            'icon' => 'users'
                        ],
                        [
                            "label" => Yii::t("app", "RBAC"),
                            "icon" => "filter",
                            "items" => [
                                [
                                    "label" => Yii::t("app/rbac", "Permissions Manager"),
                                    "url" => ['/rbac/permission'],
                                    "icon" => "check-square",
                                ],
                                [
                                    "label" => Yii::t("app/rbac", "Role Manager"),
                                    "url" => ["/rbac/role"],
                                    "icon" => "users"
                                ],
                                [
                                    "label" => Yii::t("app/rbac", "Rules Manager"),
                                    "url" => ["/rbac/rule"],
                                    "icon" => "list"
                                ],
                                [
                                    "label" => Yii::t("app/rbac", "Asignment"),
                                    "url" => ["/rbac/assignment"],
                                    "icon" => "user-plus"
                                ],
                            ]
                        ],
                        [
                            "label" => Yii::t("app", "Options"),
                            "icon" => "cogs",
                            "items" => [
                                [
                                    "label" => Yii::t("app/settings", "Library Settings"),
                                    "url" => ['/admin/settings/library-settings'],
                                    'icon' => 'wrench'
                                ],
                                [
                                    "label" => Yii::t("app/settings", "Material Types"),
                                    "url" => ['/admin/material-type/index'],
                                    'icon' => 'boxes'
                                ],
                                [
                                    "label" => Yii::t("app/settings", "Collections"),
                                    "url" => ['/admin/collections/index'],
                                    'icon' => 'tags'
                                ],
                                [
                                    "label" => Yii::t("app/settings", "Member Classify"),
                                    "url" => ['/admin/member-classify/index'],
                                    'icon' => 'users'
                                ],
                                [
                                    "label" => Yii::t("app/settings", "Checkout Privileges"),
                                    "url" => ['/admin/checkout-privs/index'],
                                    'icon' => 'check'
                                ],
                                [
                                    "label" => Yii::t("app/settings", "Themes"),
                                    "url" => ['/admin/theme/index'],
                                    'icon' => 'palette'
                                ],
                                [
                                    "label" => Yii::t("app/settings", "Flush Cache"),
                                    "url" => ['/site/flush-cache'],
                                    'icon' => 'trash'
                                ],
                            ],
                        ],
                    ],
            ]) ?>
            <?php
            echo Menu::widget([
                'items' => [
                    ['label' => 'Yii2 PROVIDED', 'header' => true, 'visible' => YII_DEBUG, 'options' => ['class' => 'nav-header']],
                    [
                        'label' => 'Login',
                        'url' => ['site/login'],
                        'icon' => 'sign-in-alt',
                        'visible' => Yii::$app->user->isGuest,
                        'options' => ['class' => 'nav-item'],
                    ],
                    [
                        'label' => 'Gii',
                        'icon' => 'file-code',
                        'url' => ['/gii'],
                        'visible' => YII_DEBUG,
                        'target' => '_blank',
                        'options' => ['class' => 'nav-item'],
                    ],
                    [
                        'label' => 'Debug',
                        'icon' => 'bug',
                        'url' => ['/debug'],
                        'visible' => YII_DEBUG,
                        'target' => '_blank',
                        'options' => ['class' => 'nav-item'],
                    ],
                ],
            ]);
?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>