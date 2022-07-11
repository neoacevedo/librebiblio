<?php

/* @var $this yii\web\View */

use dosamigos\chartjs\ChartJs;

$this->title = Yii::$app->name;
$totales = [];
$fechas = [];

$fechas[] = "";
$totales[] = "";
if (count($checkout_stats) >= 1) {
    // Hay por lo menos uno. Se itera en ese o esos, y luego se rellena.
    $count = 0;
    // iteración para días anteriores.
    for ($count = count($checkout_stats); $count >= 1; $count--) {
        $fechas[] = date('Y-m-d', strtotime("-$count day"));
        $totales[] = 0;
    }
    // iteración de los actuales.
    foreach ($checkout_stats as $checkout) {
        $fechas[] = $checkout['checkoutsPerDay'];
        $totales[] = $checkout['checkoutCount'];
    }
} else {
    // No hay. Se rellena la información.
    for ($count = 4; $count >= 1; $count--) {
        $fechas[] = date('Y-m-d', strtotime("-$count day"));
        $totales[] = 0;
    }
    
    $fechas[] = date('Y-m-d');
}
?>
<div class="site-index">
    <h1><?= Yii::t('app', 'Dashboard') ?>
    </h1>
    <div class="row">
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= $checkouts ?>
                    </h3>
                    <p><?= Yii::t("app", "Current Checkouts") ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="<?= \yii\helpers\Url::to(['admin/report/search', 'type' => 'Checkouts']) ?>"
                    class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?= $new_members ?>
                    </h3>

                    <p><?= Yii::t("app", "New Registered Members") ?>
                    </p>
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
                    <h3><?= Yii::$app->formatter->asCurrency($bills ?: 0) ?>
                    </h3>
                    <p><?= Yii::t("app", "Members Bills") ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <a href="<?= \yii\helpers\Url::to(['admin/report/search', 'type' => 'Overdue']) ?>"
                    class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Custom tabs (Charts with tabs)-->
        <section class="col-md-12 connectedSortable ui-sortable">
            <div class="card">
                <div class="card-body">
                    <?=
                    ChartJs::widget([
                        'type' => 'line',
                        /* 'options' => [
                        'height' => 400,
                        'width' => 400
                        ], */
                        'data' => [
                            'labels' => array_values($fechas),
                            'datasets' => [
                                [
                                    'label' => "Checkouts per day",
                                    'backgroundColor' => "#ffffff",
                                    'borderColor' => "#00c0ef",
                                    'pointBackgroundColor' => "#00c0ef",
                                    'pointBorderColor' => "#fff",
                                    'pointHoverBackgroundColor' => "#fff",
                                    'pointHoverBorderColor' => "#00c0ef",
                                    'data' => array_values($totales)
                                ],
                            /* [
                            'label' => "My Second dataset",
                            'backgroundColor' => "rgba(255,99,132,0.2)",
                            'borderColor' => "rgba(255,99,132,1)",
                            'pointBackgroundColor' => "rgba(255,99,132,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(255,99,132,1)",
                            'data' => [28, 48, 40, 19, 96, 27, 100]
                            ] */
                            ]
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </section>
        <!-- /.nav-tabs-custom -->
    </div>
</div>