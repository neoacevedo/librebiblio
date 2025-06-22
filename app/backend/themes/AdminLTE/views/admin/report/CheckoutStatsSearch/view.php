<?php

use backend\reports\CheckoutStats;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app/reports', 'Results');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;

$type = Yii::t('app/reports', 'Quarter');
if (Yii::$app->request->queryParams['timespan'] == "w") {
    $type = Yii::t('app/reports', 'Week');
} elseif (Yii::$app->request->queryParams['timespan'] == "m") {
    $type = Yii::t('app/reports', 'Month');
}

$filename = str_replace("Search", "-$type", Yii::$app->request->queryParams['type']);

$fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'cycle',
            'label' => Yii::t('app/reports', 'Cycle'),
        ],
        [
            'attribute' => 'checkoutCount',
            'label' => Yii::t('app/reports', "Checkout Count")
        ]
    ],
    'showConfirmAlert' => true,
    'target' => ExportMenu::TARGET_BLANK,
    'asDropdown' => true,
    'deleteAfterSave' => true,
    'exportConfig' => [
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_EXCEL => false
    ],
    'stream' => true,
    'filename' => $filename,
]);
?>
<div class="collection-index">
    <div class="card">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'cycle',
                    'label' => Yii::t('app/reports', 'Cycle'),
                ],
                [
                    'attribute' => 'checkoutCount',
                    'label' => Yii::t('app/reports', "Checkout Count")
                ]
            ],
            'panel' => [
                'headingOptions' => ['class' => 'card-header'],
                'heading' => Html::encode(Yii::t('app/reports', CheckoutStats::getName()) . " - $type"),
            ],
            'toolbar' => [
                $fullExportMenu
            ],
            'containerOptions' => ['class' => 'card-body']
        ]);
        ?>
    </div>
</div>