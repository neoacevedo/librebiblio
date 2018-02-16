<?php
/* @var $this yii\web\View */

$settings = \common\models\Settings::find()->one();
$this->title = null !== $settings->library_name ? $settings->library_name : "OpenBiblio2";
?>
<div class="site-index">
    <h1><?= Yii::t('app', 'Dashboard') ?></h1>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= $checkouts ?></h3>
                    <p><?= Yii::t('app', 'Checkout Stats') ?></p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>
