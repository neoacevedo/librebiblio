<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use yii\helpers\Html;
#use common\widgets\Alert;
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                }
                ?>
            </h1>
        <?php } ?>

        <?=
            Breadcrumbs::widget(
                [
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]
            )
        ?>
    </section>

    <section class="content">
        <div class="row">
            <!-- Alert -->
            <?= Alert::widget(); ?>
        </div>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> <?= Yii::$app->params['version'] ?>
    </div>
    <strong>Copyright &copy; <?= \date('Y') ?> <?= Html::encode(Yii::$app->name) ?>.</strong> Todos los derechos reservados.
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