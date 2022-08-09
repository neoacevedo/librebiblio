<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use backend\themes\Gentelella\assets\Asset;
use backend\themes\Gentelella\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

$bundle = Asset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?>
    </title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body
    class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>">
    <?php $this->beginBody(); ?>
    <div class="container body">

        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="/" class="site_title"><i class="fa fa-paw"></i> <span>Gentellela Alela!</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="http://placehold.it/128x128" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>John Doe</h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3><?= Yii::t("app", "Home") ?>
                            </h3>
                            <?=
                                Menu::widget([
                                    "items" => [
                                        [
                                            "label" => Yii::t("app", "Home"),
                                            "url" => ['/'],
                                            "icon" => "home"
                                        ],
                                    ],
                                ]) ?>
                        </div>
                        <div class="menu_section">
                            <h3><?= Yii::t("app", "Cataloging") ?>
                            </h3>
                            <?=
                                Menu::widget([
                                    "items" => [
                                        [
                                            "label" => Yii::t("app", "Home"),
                                            "url" => ['/cataloging/biblio'],
                                            "icon" => "check-square"
                                        ],
                                        [
                                            "label" => Yii::t("app", "Create Biblio"),
                                            "url" => ["/cataloging/biblio/create"],
                                            "icon" => "book"
                                        ],
                                        [
                                            "label" => Yii::t("app", "Reporting"),
                                            "url" => ["/admin/report/index"],
                                            "icon" => "chart-bar"
                                        ],
                                        [
                                            "label" => Yii::t("app", "Options"),
                                            "icon" => "th",
                                            'url' => '#',
                                            'options' => ['class' => 'header'],
                                            "items" => [
                                                [
                                                    "label" => Yii::t("app/settings", "Material Types"),
                                                    "url" => ['/admin/material-type/index'],
                                                ],
                                                [
                                                    "label" => Yii::t("app/settings", "Collections"),
                                                    "url" => ['/admin/collections/index']
                                                ],
                                            ],
                                        ],
                                    ],
                                ]) ?>
                        </div>
                        <div class="menu_section">
                            <h3><?= Yii::t("app", "RBAC") ?>
                            </h3>
                            <?=
                                Menu::widget([
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
                                    ],
                                ]) ?>
                        </div>


                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a href="<?= Url::to(['/admin/settings/library-settings']) ?>"
                            data-toggle="tooltip" data-placement="top" title
                            data-original-title="<?= Yii::t("app/settings", "Library Settings") ?>">
                            <span class="fas fa-cogs" aria-hidden="true"></span>
                        </a>
                        <a href="<?= Url::to(['/admin/flush-cache']) ?>"
                            data-toggle="tooltip" data-placement="top"
                            title="<?= Yii::t("app/settings", "Flush Cache") ?>">
                            <span class="fas fa-trash" aria-hidden="true"></span>
                        </a>
                        <a href="<?= Url::to(['/admin/theme/index']) ?>"
                            data-toggle="tooltip" data-placement="top"
                            title="<?= Yii::t("app/settings", "Themes") ?>">
                            <span class="fas fa-palette" aria-hidden="true"></span>
                        </a>
                        <a href="<?= Url::to(['site/logout']) ?>"
                            data-method="post" data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="fas fa-power-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="http://placehold.it/128x128" alt="">John Doe
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right">
                                    <a class="dropdown-item" href="javascript:;"> Profile</a>

                                    <a class="dropdown-item" href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>

                                    <a class="dropdown-item" href="javascript:;">Help</a>
                                    <a class="dropdown-item" href="login.html"><i class="fa fa-sign-out pull-right"></i>
                                        Log Out</a>
                                </div>
                            </li>

                            <li role="presentation" class="nav-item dropdown open">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="far fa-envelope"></i>
                                    <span class="badge bg-green">6</span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    <li>
                                        <a>
                                            <span class="image">
                                                <img src="http://placehold.it/128x128" alt="Profile Image" />
                                            </span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                                <img src="http://placehold.it/128x128" alt="Profile Image" />
                                            </span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                                <img src="http://placehold.it/128x128" alt="Profile Image" />
                                            </span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                                <img src="http://placehold.it/128x128" alt="Profile Image" />
                                            </span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were
                                                where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="text-center">
                                            <a href="/">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <?php if (!is_null($this->title)): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->title ?>
                        </h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Go!</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="clearfix"></div>

                <?= $content ?>
            </div>
            <!-- /page content -->
            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com" rel="nofollow"
                        target="_blank">Colorlib</a><br />
                    Extension for Yii framework 2 by <a href="http://yiister.ru" rel="nofollow"
                        target="_blank">Yiister</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>
    <!-- /footer content -->
    <?php $this->endBody(); ?>
</body>

</html>
<?php $this->endPage();
