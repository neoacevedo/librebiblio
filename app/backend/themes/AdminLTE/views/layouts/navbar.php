<?php

use yii\bootstrap4\Nav;
use yii\helpers\Html;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <?= Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            [
                'encode' => false,
                'label' => '<i class="fas fa-bars"></i>',
                'url' => "#",
                'linkOptions' => [
                    'data-widget' => 'pushmenu',
                    'role' => 'button'
                ]
            ],
            [
                'label' => Yii::t("app", "Home"),
                'url' => ['site/index'],
            ],
            [
                'label' => Yii::t("app", "Circulation"),
                'url' => ['/circulation/index']
            ],
            [
                'label' => Yii::t("app", "Check in"),
                'url' => ['/circulation/reception']
            ],
            [
                'label' => Yii::t("app/reports", "Reports"),
                'url' => ['/admin/reports']
            ]
        ],
    ]) ?>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Solicitudes de reserva. -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge"><?= count(common\models\BiblioHold::find()->all()); ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header"><?= Yii::t('app', 'Bibliographies Currently On Hold'); ?></span>
                <div class="dropdown-divider"></div>
                <?php
                        $hldCopies = common\models\BiblioHold::find()->limit(5)->all();
if ($hldCopies):
    foreach ($hldCopies as $hld):
        $mbr = \common\models\Member::findOne($hld->mbr_id);
        $copy = \common\models\BiblioCopy::findOne($hld->copyid);
        ?>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user-circle-o"></i><?php echo "{$mbr->username} ".Yii::t('circulation', 'placed hold copy').' '.$copy->barcode_nmbr; ?>
                </a>
                <div class="dropdown-divider"></div>
                <?php
    endforeach;
else:
    ?>
                <span class="dropdown-item">
                    <i class="fas fa-circle-thin"><?= Yii::t('circulation', 'No new holds'); ?></i>
                </span>
                <?php
endif;
?>
                <span class="dropdown-footer"></span>
            </div>
        </li>
        <!-- // -->

        <!-- carrito -->
        <li class="nav-item">
            <a class="nav-link"
                href="<?= yii\helpers\Url::to(['/circulation/cart']); ?>">
                <i class="fas fa-shopping-cart"></i>
                <span class="badge badge-info navbar-badge"><?= count(common\models\BiblioCopy::findAll(['status_cd' => 'crt'])); ?></span>
            </a>
        </li>
        <!-- // -->

        <!-- Staff -->
        <li class="nav-item">
            <a class="nav-link"
                href="<?= yii\helpers\Url::to(['/user/index']) ?>"
                alt="<?= Yii::t('app', 'Staff') ?>"><i
                    class="fas fa-users"></i></a>
        </li>

        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->