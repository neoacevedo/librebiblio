<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

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
