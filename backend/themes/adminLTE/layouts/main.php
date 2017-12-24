<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);

$settings = \common\models\Settings::find()->one();
$library_name = null !== $settings->library_name ? $settings->library_name : "OpenBiblio2";
$library_hours = null !== $settings->library_hours ? $settings->library_hours : "N/A";
$bodyClass = (isset($this->context->bodyClass)) ? $this->context->bodyClass : "hold-transition skin-blue sidebar-mini";
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <!--<link rel="stylesheet" href="<?= yii\helpers\Url::to("@web/themes/adminLTE/css/AdminLTE.css") ?>" />
        <link rel="stylesheet" href="<?= yii\helpers\Url::to("@web/themes/adminLTE/css/skins/_all-skins.min.css") ?>" />
        <link rel="stylesheet" href="<?= yii\helpers\Url::to("@web/themes/adminLTE/css/openbiblio.css") ?>" />-->
        <!-- Font Awesome -->
        <style>
            .wrapper {
                background-color: #ecf0f5 !important;
                padding-bottom: 15px;
            }

            .main-sidebar {
                background-color: #222d32;
                height: 100% !important;
            }
        </style>
    </head>
    <body class="<?= $bodyClass; ?>">
        <?php $this->beginBody() ?>
        <?php
        if (Yii::$app->user->isGuest):
            // login
            ?>
            <div class="wrap">
                <div class="content">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>
            <?php
        else:
            // admin area
            ?>
            <div class="wrapper">

                <header class="main-header">
                    <!-- Logo -->
                    <?php
                    echo Html::a($library_name, Yii::$app->homeUrl, ['class' => 'logo']);
                    $roles = \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                    $isAdmin = false;
                    foreach ($roles as $role) {
                        if ($role->name == "admin") {
                            $isAdmin = true;
                        }
                    }
                    ?>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>

                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <!-- carrito -->
                                <li class="task-menu">
                                    <a href="<?= yii\helpers\Url::to(['/circulation/cart']) ?>"><i class="fa fa-shopping-cart"></i></a>
                                </li>
                                <!-- User Account: style can be found in dropdown.less -->
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <!--<img src="img/user2-160x160.jpg" class="img-circle" alt="" />-->
                                        <span><?= Yii::$app->user->identity->username ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- User image -->
                                        <!--<li class="user-header">
                                            <img src="img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                            <p>
                                        <?= Yii::$app->user->identity->username ?>
                                            </p>
                                        </li>-->
                                        <!-- Menu Body -->
                                        <li class="user-body">
                                            <?php
                                            if ($isAdmin):
                                                ?>
                                                <div class="row">
                                                    <div class="col-xs-4 text-center">&nbsp;</div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="<?= yii\helpers\Url::to(['/admin/users']) ?>">
                                                            <i class="fa fa-users"></i> <?= Yii::t('app', 'Staff') ?>
                                                        </a>                                                        
                                                    </div>
                                                    <div class="col-xs-4 text-center">&nbsp;</div>
                                                </div>
                                                <?php
                                            endif;
                                            ?>
                                            <!-- /.row -->
                                        </li>
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <!--<div class="pull-left">
                                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                            </div>-->
                                            <div class="pull-right">
                                                <!--<a href="#" class="btn btn-default btn-flat">Sign out</a>-->
                                                <?php
                                                Html::beginForm(['/site/logout'], 'post');
                                                echo Html::submitButton(
                                                        Yii::t('app', 'Logout'), ['class' => 'btn btn-link logout']
                                                );
                                                Html::endForm();
                                                ?>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <!-- Control Sidebar Toggle Button -->
                                <li>
                                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <?php
                $menuItems[] = ['label' => Yii::t('app', 'Circulation'), 'url' => ["#"],
                    'options' => ['class' => 'treeview menu'],
                    'template' => '<a href="{url}" ><i class="fa fa-address-book-o"></i><span>{label}</span></a>',
                    'items' => [
                        ['label' => Yii::t('app', 'Home'), 'url' => ['circulation/index']],
                        ['label' => Yii::t('app', 'New Member'), 'url' => ['circulation/member-create']],
                        ['label' => Yii::t('app', 'Check in'), 'url' => ['circulation/checkin']]
                ]];
                $menuItems[] = [
                    'template' => '<a href="{url}" ><i class="fa fa-book"></i><span>{label}</span></a>',
                    'label' => Yii::t('app', 'Cataloging'), 'url' => ['/cataloging/biblio']];
                if ($isAdmin) {
                    $menuItems[] = ['label' => Yii::t('app/reports', 'Reports')];
                }
                ?>
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <!-- Sidebar user panel -->
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNjA4NGU1YWZiMCB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE2MDg0ZTVhZmIwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQxLjUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" class="img-circle" alt="" />
                            </div>
                            <div class="pull-left info">
                                <p><?= Yii::$app->user->identity->username ?></p>
                                <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
                            </div>
                        </div>

                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <?=
                        Menu::widget([
                            'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                            'items' => $menuItems,
                            'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
                        ])
                        ?>
                    </section>
                    <!--/.sidebar -->
                </aside>
                <? = Alert::widget()
                ?>

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <?php
                        echo Breadcrumbs::widget([
                            'options' => ['class' => 'breadcrumb pull-left'],
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]);
                        ?>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <?= Alert::widget() ?>
                        <?= $content ?>
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                <footer>
                    <div class="pull-right hidden-xs">
                        <div class="main-footer">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="col-md-4"><?= Yii::t('library', 'Date') . ": " . Yii::$app->formatter->asDate("now", "full") ?></div>
                                    <div class="col-md-4"><?= Yii::t('library', 'Library Hours') . ": $library_hours" ?></div>
                                    <div class="col-md-4"><?= Yii::t('library', 'Library Phone') . ": $library_phone" ?></div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="col-lg-4 col-md-4 col-sm-4">OpenBiblio. &copy; 2002-2005 Dave Stevens, et al.</div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">OpenBiblio2, <?= date('Y') ?></div>
                                    <div class="col-lg-4 col-md-4 col-sm-4"><?= Yii::powered() ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>

                <!-- Control Sidebar -->
                <aside class="control-sidebar control-sidebar-dark">

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Settings tab content -->
                        <div id="control-sidebar-settings-tab">
                            <form method="post">
                                <h3 class="control-sidebar-heading"><?= Yii::t('app', 'Options') ?></h3>

                                <div class="form-group">
                                    <?= Html::a(Yii::t('app/settings', 'Library Settings'), yii\helpers\Url::to(['admin/settings/library-settings']), ['class' => 'control-sidebar-subheading']) ?>

                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Allow mail redirect
                                        <input type="checkbox" class="pull-right" checked>
                                    </label>

                                    <p>
                                        Other sets of options are available
                                    </p>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Expose author name in posts
                                        <input type="checkbox" class="pull-right" checked>
                                    </label>

                                    <p>
                                        Allow the user to show his name in blog posts
                                    </p>
                                </div>
                                <!-- /.form-group -->

                                <h3 class="control-sidebar-heading">Chat Settings</h3>

                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Show me as online
                                        <input type="checkbox" class="pull-right" checked>
                                    </label>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Turn off notifications
                                        <input type="checkbox" class="pull-right">
                                    </label>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Delete chat history
                                        <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                                    </label>
                                </div>
                                <!-- /.form-group -->
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                </aside>
                <!-- /.control-sidebar -->
                <!-- Add the sidebar's background. This div must be placed
                     immediately after the control sidebar -->
                <div class="control-sidebar-bg"></div>
            </div>
            <!-- ./wrapper -->
        <?php
        endif;
        ?>
        <?php $this->endBody() ?>
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
    </body>
</html>
<?php $this->endPage() ?>