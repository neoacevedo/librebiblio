<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;

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
            $attributes = array_merge([
                ['class' => 'yii\grid\SerialColumn']], array_keys($columns)
            );
        } else {
            $attributes = array_merge([
                ['class' => 'yii\grid\SerialColumn']], array_keys($model[0]->attributes)
            );
        }
    } else {
        $attributes = array_merge([
            ['class' => 'yii\grid\SerialColumn']], array_keys($model[0]->attributes)
        );
    }
} else {
    $attributes = array_merge([
        ['class' => 'yii\grid\SerialColumn']], array_keys($searchModel->attributes)
    );
}

$route = Yii::$app->request->queryParams;
array_shift($route);
$pdfRoute = array_merge(["admin/report/pdf"], $route);
$excelRoute = array_merge(["admin/report/excel"], $route);
$csvRoute = array_merge(['admin/report/csv'], $route);
$isFa = false;
?>
<div class="collection-index">
    <div class="col-xs-6">
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>
    <div class="col-xs-6">
        <?php
        echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $attributes,
            'showConfirmAlert' => true,
            'target' => ExportMenu::TARGET_BLANK,
            'exportConfig' => [
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_CSV => [
                    'label' => 'CSV',
                    'icon' => $isFa ? 'file-code-o' : 'floppy-open',
                    'iconOptions' => ['class' => 'text-primary'],
                    'linkOptions' => [],
                    'options' => ['title' => Yii::t('app/reports', 'Comma Separated Values')],
                    'alertMsg' => Yii::t('app/reports', 'The CSV export file will be generated for download.'),
                    'mime' => 'application/csv',
                    'extension' => 'csv',
                    'writer' => 'CSV'
                ],
                ExportMenu::FORMAT_PDF => [
                    'label' => 'PDF',
                    'icon' => $isFa ? 'file-pdf-o' : 'floppy-disk',
                    'iconOptions' => ['class' => 'text-danger'],
                    'linkOptions' => [],
                    'options' => ['title' => Yii::t('app/reports', 'Portable Document Format')],
                    //'alertMsg' => Yii::t('app/reports', 'The PDF export file will be generated for download.'),
                    'mime' => 'application/pdf',
                    'extension' => 'pdf',
                    'writer' => 'PDF'
                ],
                ExportMenu::FORMAT_EXCEL => [
                    'label' => 'Excel 95 +',
                    'icon' => $isFa ? 'file-excel-o' : 'floppy-remove',
                    'iconOptions' => ['class' => 'text-success'],
                    'linkOptions' => [],
                    'options' => ['title' => Yii::t('app/reports', 'Microsoft Excel 95+ (xls)')],
                    'alertMsg' => Yii::t('app/reports', 'The EXCEL 95+ (xls) export file will be generated for download.'),
                    'mime' => 'application/vnd.ms-excel',
                    'extension' => 'xls',
                    'writer' => 'Excel5'
                ],
                ExportMenu::FORMAT_EXCEL_X => [
                    'label' => 'Excel 2007+',
                    'icon' => $isFa ? 'file-excel-o' : 'floppy-remove',
                    'iconOptions' => ['class' => 'text-success'],
                    'linkOptions' => [],
                    'options' => ['title' => Yii::t('app/reports', 'Microsoft Excel 2007+ (xlsx)')],
                    'alertMsg' => Yii::t('app/reports', 'The EXCEL 2007+ (xlsx) export file will be generated for download.'),
                    'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'extension' => 'xlsx',
                    'writer' => 'Excel2007'
                ],
            ],
            'container' => ['class'=>'h1 btn-group pull-right', 'role'=>'group']
        ]);
        ?>
    </div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $attributes,
        'options' => ['class' => 'table table-striped table-bordered table-responsive']
    ])
    ?>
</div>
