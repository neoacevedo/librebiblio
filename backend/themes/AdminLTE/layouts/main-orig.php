<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);

//$settings = \common\models\Settings::find()->one();
$library_name = Yii::$app->name; //null !== $settings->library_name ? $settings->library_name : "OpenBiblio2";
$library_hours = \common\models\Settings::find()->one()->library_hours; //null !== $settings->library_hours ? $settings->library_hours : "N/A";
$library_phone = \common\models\Settings::find()->one()->library_phone; //null !== $settings->library_phone ? $settings->library_phone : "N/A";
$bodyClass = (isset($this->context->bodyClass)) ? $this->context->bodyClass : 'hold-transition sidebar-mini skin-'.Yii::$app->session['backend-skin'];
$roles = \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
$isAdmin = false;
foreach ($roles as $role) {
    if ($role->name == 'admin') {
        $isAdmin = true;
    }
}
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
    <head>
        <meta charset="<?= Yii::$app->charset; ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <?= Html::csrfMetaTags(); ?>
        <title><?= Html::encode($this->title); ?></title>
        <?php $this->head(); ?>
        <!--<link rel="stylesheet" href="<?= yii\helpers\Url::to('@web/themes/adminLTE/css/AdminLTE.css'); ?>" />
        <link rel="stylesheet" href="<?= yii\helpers\Url::to('@web/themes/adminLTE/css/skins/_all-skins.min.css'); ?>" />
        <link rel="stylesheet" href="<?= yii\helpers\Url::to('@web/themes/adminLTE/css/openbiblio.css'); ?>" />-->
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
        <?php $this->beginBody(); ?>
        <?php
        if (Yii::$app->user->isGuest):
            // login
            ?>
            <div class="wrap">
                <div class="content">
                    <?= Alert::widget(); ?>
                    <?= $content; ?>
                </div>
            </div>
            <?php
        else:
            // admin area
            ?>
            <!--<div class="wrapper">-->

                <header class="main-header">
                    <!-- Logo -->
                    <?=
                    Html::a('<span class="logo-mini">OB2</span><span class="logo-lg">'.$library_name.'</span>', Yii::$app->homeUrl, ['class' => 'logo']);
                    ?>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>

                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <!-- Solicitudes de reserva. -->
                                <li class="dropdown notifications-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-bell"></i>
                                        <span class="label label-default"><?= count(common\models\BiblioHold::find()->all()); ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header"><?= Yii::t('app', 'Bibliographies Currently On Hold'); ?></li>
                                        <?php
                                        $hldCopies = common\models\BiblioHold::find()->limit(5)->all();
                                        if ($hldCopies):
                                            ?>
                                            <li>
                                                <!-- data -->
                                                <ul class="menu">
                                                    <?php
                                                    foreach ($hldCopies as $hld):
                                                        $mbr = \common\models\Member::findOne($hld->mbr_id);
                                                        $copy = \common\models\BiblioCopy::findOne($hld->copyid);
                                                        ?>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-user-circle-o"></i><?php echo "{$mbr->username} ".Yii::t('circulation', 'placed hold copy').' '.$copy->barcode_nmbr; ?>
                                                            </a>
                                                        </li>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </ul>
                                            </li>
                                            <li class="footer"><a href="#">&nbsp;</a></li>
                                            <?php
                                        else:
                                            ?>
                                            <li>
                                                <!-- data -->
                                                <ul class="menu">
                                                    <li class="fa fa-circle-thin"><?= Yii::t('circulation', 'No new holds'); ?></li>
                                                </ul>
                                            </li>
                                            <li class="footer"><a href="#">&nbsp;</a></li>
                                        <?php
                                        endif;
                                        ?>
                                    </ul>
                                </li>
                                <!-- carrito -->
                                <li class="task-menu">
                                    <a href="<?= yii\helpers\Url::to(['/circulation/cart']); ?>">
                                        <i class="fa fa-shopping-cart"></i>
                                        <span class="label label-warning"><?= count(common\models\BiblioCopy::findAll(['status_cd' => 'crt'])); ?></span>
                                    </a>
                                </li>
                                <!-- User Account: style can be found in dropdown.less -->
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <!--<img src="img/user2-160x160.jpg" class="img-circle" alt="" />-->
                                        <span><?= Yii::$app->user->identity->username; ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- User image -->
                                        <!--<li class="user-header">
                                            <img src="img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                            <p>
                                        <?= Yii::$app->user->identity->username; ?>
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
                                                        <a href="<?= yii\helpers\Url::to(['/admin/users']); ?>">
                                                            <i class="fa fa-users"></i> <?= Yii::t('app', 'Staff'); ?>
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
                                                <?php
                                                echo Html::beginForm(['/site/logout'], 'post')
                                                .Html::submitButton(
                                                        Yii::t('app', 'Logout'), ['class' => 'btn btn-link logout']
                                                )
                                                .Html::endForm();
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
                // circulación
                $menuItems[] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['#'],
                    'options' => ['class' => 'treeview menu'],
                    'template' => '<a href="{url}" ><i class="fa fa-address-book-o"></i><span>{label}</span></a>',
                    'items' => [
                        ['label' => Yii::t('app', 'Home'), 'url' => ['circulation/index']],
                        ['label' => Yii::t('app', 'New Member'), 'url' => ['member/create']],
                        ['label' => Yii::t('app', 'Check in'), 'url' => ['circulation/reception']],
                ], ];
                // catalogación
                $menuItems[] = ['label' => Yii::t('app', 'Cataloging'), 'url' => ['#'],
                    'options' => ['class' => 'treeview menu'],
                    'template' => '<a href="{url}" ><i class="fa fa-book"></i><span>{label}</span></a>',
                    'items' => [
                        ['label' => Yii::t('app', 'Home'), 'url' => ['/cataloging/biblio']],
                        ['label' => Yii::t('app', 'Create Biblio'), 'url' => ['/cataloging/biblio/create']],
                ], ];
                // reportes
                $menuItems[] = [
                    'template' => '<a href="{url}" ><i class="fa fa-bar-chart"></i><span>{label}</span></a>',
                    'label' => Yii::t('app/reports', 'Reports'), 'url' => ['admin/report/index'],
                    'items' => [], ];
                ?>
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <!-- Sidebar user panel -->
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img src="<?= Yii::$app->urlManager->baseUrl; ?>/themes/AdminLTE/img/user1-300px.png" class="img-circle" alt="" />
                            </div>
                            <div class="pull-left info">
                                <p><?= Yii::$app->user->identity->username; ?></p>
                                <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
                            </div>
                        </div>

                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <?=
                        Menu::widget([
                            'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                            'items' => $menuItems,
                            'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
                        ]);
                        ?>
                    </section>
                    <!--/.sidebar -->
                </aside>

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="row">
                            <?php
                            echo Breadcrumbs::widget([
                                'options' => ['class' => 'breadcrumb pull-right'],
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ]);
                            ?>
                        </div>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <?= Alert::widget(); ?>
                        </div>
                        <?= $content; ?>
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                <footer>
                    <div class="pull-right hidden-xs">
                        <div class="row">&nbsp;</div>
                        <div class="main-footer">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="col-md-4"><?= Yii::t('library', 'Date').': '.Yii::$app->formatter->asDate('now', 'full'); ?></div>
                                    <div class="col-md-4"><?= Yii::t('library', 'Library Hours').": $library_hours"; ?></div>
                                    <div class="col-md-4"><?= Yii::t('library', 'Library Phone').": $library_phone"; ?></div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="col-lg-4 col-md-4 col-sm-4">OpenBiblio. &copy; 2002-2005 Dave Stevens, et al.</div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">OpenBiblio2. &copy; <?= date('Y'); ?> N&eacute;stor Acevedo. <?= 'v'.Yii::$app->params['version']; ?></div>
                                    <div class="col-lg-4 col-md-4 col-sm-4"><?= Yii::powered(); ?></div>
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
                                <h3 class="control-sidebar-heading"><?= Yii::t('app', 'Options'); ?></h3>

                                <div class="form-group">
                                    <?= Html::a(Yii::t('app/settings', 'Library Settings'), yii\helpers\Url::to(['admin/settings/library-settings']), ['class' => 'control-sidebar-subheading']); ?>

                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <?= Html::a(Yii::t('app/settings', 'Material Types'), yii\helpers\Url::to(['admin/material-type/index']), ['class' => 'control-sidebar-subheading']); ?>

                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <?= Html::a(Yii::t('app/settings', 'Collections'), yii\helpers\Url::to(['admin/collections/index']), ['class' => 'control-sidebar-subheading']); ?>

                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <?= Html::a(Yii::t('app/settings', 'Member Classify'), yii\helpers\Url::to(['admin/member-classify/index']), ['class' => 'control-sidebar-subheading']); ?>

                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <?= Html::a(Yii::t('app/settings', 'Checkout Privileges'), yii\helpers\Url::to(['admin/checkout-privs/index']), ['class' => 'control-sidebar-subheading']); ?>

                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <?= Html::a(Yii::t('app/settings', 'Themes'), yii\helpers\Url::to(['admin/theme/index']), ['class' => 'control-sidebar-subheading']); ?>

                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <!-- /.form-group -->
                                
                                <div class="form-group">
                                    <?= Html::a(Yii::t('app/settings', 'Flush Cache'), yii\helpers\Url::to(['admin/flush-cache']), ['class' => 'control-sidebar-subheading']); ?>

                                    <p>
                                        &nbsp;
                                    </p>
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
            <!--</div>-->
            <!-- ./wrapper -->
        <?php
        endif;
        ?>
        <?php $this->endBody(); ?>
        <script>
            $.widget.bridge('uibutton', $.ui.button);
            $(".alert").fadeTo(3000, 500).slideUp(1000, function () {
                $(".alert").alert('close');
            });
        </script>
    </body>
</html>
<?php $this->endPage(); ?>
