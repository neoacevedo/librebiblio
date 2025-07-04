<?php

/* @var $this yii\web\View */
/** @var yii\data\ActiveDataProvider $logs  */

use neoacevedo\chartjs\ChartJs;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Dashboard');
$totales = [];
$fechas = [];

$fechas[] = "";
$totales[] = "";
if (count($checkout_stats) >= 1 && count($checkout_stats) < 7) {
    // Hay por lo menos uno. Se itera en ese o esos, y luego se rellena.
    // iteración de los actuales.
    foreach ($checkout_stats as $checkout) {
        $fechas[] = $checkout['checkoutsPerDay'];
        $totales[] = $checkout['checkoutCount'];
    }

    $origin = new DateTimeImmutable($fechas[count($fechas) - 1]);
    $actual = new DateTimeImmutable("now");
    $date_diff = $actual->diff($origin);
    $count = $date_diff->days - 1 ?? 1;

    // iteración para días siguientes a la última fecha.
    for ($i = 1; $i < $count; $i++) {
        $fechas[] = date('Y-m-d', strtotime("+$i day", $origin->getTimestamp()));
        $totales[] = 0;
    }
} else {
    // No hay. Se rellena la información.

    $fechas[] = date('Y-m-d');
    $totales[] = 0;
    for ($count = 1; $count < 4; $count++) {
        $fechas[] = date('Y-m-d', strtotime("+$count day", time()));
        $totales[] = 0;
    }
}
?>
<div class="site-index">
    <div class="row">
        <div class="col">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?= $checkouts ?>
                    </h3>
                    <p>
                        <?= Yii::t("app", "Current Checkouts") ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <a href="<?= \yii\helpers\Url::to(['admin/report/search', 'type' => 'Checkouts']) ?>"
                    class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <?= $new_members ?>
                    </h3>

                    <p>
                        <?= Yii::t("app", "New Registered Members") ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?= Yii::$app->formatter->asCurrency($bills ?: 0) ?>
                    </h3>
                    <p>
                        <?= Yii::t("app", "Members Bills") ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="<?= \yii\helpers\Url::to(['admin/report/search', 'type' => 'Overdue']) ?>"
                    class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Custom tabs (Charts with tabs)-->
        <section class="col-sm connectedSortable ui-sortable">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <?= Yii::t("app", "Statistics") ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php
                    echo ChartJs::widget([
                        'type' => 'line',
                        /* 'options' => [
                        'height' => 400,
                        'width' => 400
                        ], */
                        'data' => [
                            'labels' => array_values($fechas),
                            'datasets' => [
                                [
                                    'label' => Yii::t("app", "Checkouts per day"),
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
        <!-- // -->
        <section class="col-sm">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <?= Yii::t("app", "Recent Activity") ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?= GridView::widget([
                        'dataProvider' => $logs,
                        'columns' => [
                            'description',
                            'created_at:date'
                        ]
                    ])
                        ?>
                </div>
            </div>
        </section>
    </div>
</div>