<?php
/* @var $assetDir string */

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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-filter"></i> <?= Yii::t("app", "RBAC") ?>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Url::to(['/rbac/permission']) ?>"
                                class="nav-link">
                                <i class="fas fa-check-square"></i> <?= Yii::t("app/rbac", "Permissions Manager") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/rbac/role']) ?>"
                                class="nav-link">
                                <i class="fas fa-users"></i> <?= Yii::t("app/rbac", "Role Manager") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/rbac/rule']) ?>"
                                class="nav-link">
                                <i class="fas fa-list"></i> <?= Yii::t("app/rbac", "Rules Manager") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/rbac/assignment']) ?>"
                                class="nav-link">
                                <i class="fas fa-user-plus"></i> <?= Yii::t("app/rbac", "Assignment") ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-address-book"></i> <?= Yii::t("app", "Circulation") ?>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Url::to(['/circulation/index']) ?>"
                                class="nav-link">
                                <i class="fas fa-check-square"></i> <?= Yii::t("app", "Home") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/member/create']) ?>"
                                class="nav-link">
                                <i class="fas fa-users"></i> <?= Yii::t("app", "New Member") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/circulation/reception']) ?>"
                                class="nav-link">
                                <i class="fas fa-list"></i> <?= Yii::t("app", "Check in") ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-book"></i> <?= Yii::t("app", "Cataloging") ?>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Url::to(['/cataloging/biblio']) ?>"
                                class="nav-link">
                                <i class="fas fa-check-square"></i> <?= Yii::t("app", "Home") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/cataloging/biblio/create']) ?>"
                                class="nav-link">
                                <i class="fas fa-book"></i> <?= Yii::t("app", "Create Biblio") ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= Url::to(['/admin/report/index']) ?>"
                        class="nav-link">
                        <i class="fas fa-chart-bar"></i> <?= Yii::t("app/reports", "Reports") ?>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cogs"></i> <?= Yii::t("app", "Options") ?>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Url::to(['/admin/settings/library-settings']) ?>"
                                class="nav-link">
                                <i class="fas fa-wrench"></i> <?= Yii::t("app/settings", "Library Settings") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/admin/material-type/index']) ?>"
                                class="nav-link">
                                <i class="fas fa-books"></i> <?= Yii::t("app/settings", "Material Types") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/admin/collections/index']) ?>"
                                class="nav-link">
                                <i class="fas fa-tags"></i> <?= Yii::t("app/settings", "Collections") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/admin/member-classify/index']) ?>"
                                class="nav-link">
                                <i class="fas fa-users"></i> <?= Yii::t("app/settings", "Member Classify") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/admin/checkout-privs/index']) ?>"
                                class="nav-link">
                                <i class="fas fa-check"></i> <?= Yii::t("app/settings", "Checkout Privileges") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/admin/theme/index']) ?>"
                                class="nav-link">
                                <i class="fas fa-palette"></i> <?= Yii::t("app/settings", "Themes") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['/admin/flush-cache']) ?>"
                                class="nav-link">
                                <i class="fas fa-trash"></i> <?= Yii::t("app/settings", "Flush Cache") ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php
            echo \yii\widgets\Menu::widget([
                'options' => [
                    'class' => 'nav nav-pills sidebar',
                    'role' => 'menu'
                ],
                'linkTemplate' => '<a href="{url}" class="nav-link">{label}</a>',
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
                        'target' => '_blank',
                        'visible' => YII_DEBUG,
                        'options' => ['class' => 'nav-item'],
                    ],
                    [
                        'label' => 'Debug',
                        'icon' => 'bug',
                        'url' => ['/debug'],
                        'target' => '_blank',
                        'visible' => YII_DEBUG,
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