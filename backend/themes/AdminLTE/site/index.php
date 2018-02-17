<?php
/* @var $this yii\web\View */

$settings = \common\models\Settings::find()->one();
$this->title = null !== $settings->library_name ? $settings->library_name : "OpenBiblio2";
?>
<div class="site-index">
    <h1><?= Yii::t('app', 'Dashboard') ?></h1>
    <div class="row">
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= $checkouts ?></h3>
                    <p><?= Yii::t('app', 'Current Checkouts') ?></p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="<?= \yii\helpers\Url::to(['admin/report/search', 'type' => 'Checkouts']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= $new_members ?></h3>

              <p><?= Yii::t('app', 'Member Registrations') ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-4 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?= Yii::$app->formatter->asCurrency($checkouts) ?></h3>
                    <p><?= Yii::t('app', 'Bills') ?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <a href="<?= \yii\helpers\Url::to(['admin/report/search', 'type' => 'Overdue']) ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>
