<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/reports', 'Results');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;

// take just first model in the list
$model = $dataProvider->models;
if (count($model) > 0) {
    $groupBy = Yii::$app->request->get("groupBy");
    if (null !== $groupBy) {
        if ($groupBy === "biblio") {
            $columns = [];
            foreach ($model[0]->attributes as $key => $value) {
                if ($key === "barcode_nmbr") {
                    continue;
                }

                $columns[$key] = $value;
            }
            $gridColumns = array_merge([
                ['class' => 'kartik\grid\SerialColumn']], array_keys($columns)
            );
        } else {
            $gridColumns = array_merge([
                ['class' => 'kartik\grid\SerialColumn']], array_keys($model[0]->attributes)
            );
        }
    } else {
        $gridColumns = array_merge([
            ['class' => 'kartik\grid\SerialColumn']], array_keys($model[0]->attributes)
        );
    }
    $pdfHeader = [
        'L' => [
            'content' => Yii::t('app/reports', "Results"),
            'font-size' => 8,
            'color' => '#333333',
        ],
        'C' => [
            'content' => Yii::t('app/reports', $model[0]->name),
            'font-size' => 16,
            'color' => '#333333',
        ],
        'R' => [
            'content' => Yii::t('app/reports', 'Generated') . ': ' . date('D, d-M-Y g:i a T'),
            'font-size' => 8,
            'color' => '#333333',
        ],
    ];
    $pdfFooter = [
        'L' => [
            'content' => '© OpenBiblio2',
            'font-size' => 8,
            'font-style' => 'B',
            'color' => '#999999',
        ],
        'R' => [
            'content' => '[ {PAGENO} ]',
            'font-size' => 10,
            'font-style' => 'B',
            'font-family' => 'serif',
            'color' => '#333333',
        ],
        'line' => true,
    ];
} else {
    $gridColumns = array_merge([
        ['class' => 'kartik\grid\SerialColumn']], array_keys($searchModel->attributes)
    );
    $pdfHeader = [
        'L' => [
            'content' => Yii::t('app/reports', 'Results'),
            'font-size' => 8,
            'color' => '#333333',
        ],
        'C' => [
            'content' => str_replace("Search", "", Yii::$app->request->get("type")),
            'font-size' => 16,
            'color' => '#333333',
        ],
        'R' => [
            'content' => Yii::t('app/reports', 'Generated') . ': ' . date('D, d-M-Y g:i a T'),
            'font-size' => 8,
            'color' => '#333333',
        ],
    ];
    $pdfFooter = [
        'L' => [
            'content' => '© OpenBiblio2',
            'font-size' => 8,
            'font-style' => 'B',
            'color' => '#999999',
        ],
        'R' => [
            'content' => '[ {PAGENO} ]',
            'font-size' => 10,
            'font-style' => 'B',
            'font-family' => 'serif',
            'color' => '#333333',
        ],
        'line' => true,
    ];
}
?>
<div class="collection-index">
    <div class="box">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'panel' => [
                'headingOptions' => ['class' => 'box-header'],
                'heading' => '<h1>' . Html::encode($this->title) . '</h1>',
                'footer' => false
            ],
            'exportConfig' => [
                GridView::PDF => [
                    'config' => [
                        'methods' => [
                            'SetHeader' => [
                                ['odd' => $pdfHeader, 'even' => $pdfHeader],
                            ],
                            'SetFooter' => [
                                ['odd' => $pdfFooter, 'even' => $pdfFooter],
                            ],
                        ],
                    ],
                    'filename' => (count($model) > 0) ? $model[0]->name: Yii::$app->request->get("type"),
                ],
                GridView::CSV => ['filename' => (count($model) > 0) ? $model[0]->name: Yii::$app->request->get("type"),],
                GridView::EXCEL => ['filename' => (count($model) > 0) ? $model[0]->name: Yii::$app->request->get("type"),],
            ],
            'toolbar' => [
                '{export}',
            ],
            'containerOptions' => ['class' => 'box-body']
        ]);
        ?>
    </div>
</div>
