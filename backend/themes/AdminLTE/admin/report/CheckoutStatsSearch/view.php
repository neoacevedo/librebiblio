<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/reports', 'Results');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;

$filename = str_replace("Search", "", Yii::$app->request->queryParams['type']);

$fullExportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'attribute' => 'created_at',
                    'label' => Yii::t('app/reports', 'Cycle'),
                    'value' => function($model) {
                        if (Yii::$app->request->queryParams['timespan'] == 'w') {
                            return strftime("%x %V", strtotime($model->created_at));
                        } elseif (Yii::$app->request->queryParams['timespan'] == 'w') {
                            return strftime("%Y %m", strtotime($model->created_at));
                        }
                    }
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
    <div class="box">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'attribute' => 'created_at',
                    'label' => Yii::t('app/reports', 'Cycle'),
                    'value' => function($model) {
                        if (Yii::$app->request->queryParams['timespan'] === 'w') {
                            return strftime("%G %V", strtotime($model->created_at));
                        } elseif (Yii::$app->request->queryParams['timespan'] === 'm') {
                            return strftime("%Y %m", strtotime($model->created_at));
                        } elseif (Yii::$app->request->queryParams['timespan'] === 'q') {
                            return date('Y', strtotime($model->created_at)) . " " . ceil(date('n', strtotime($model->created_at)) / 3);
                        }
                    }
                ],
                'checkoutCount'
            ],
            'panel' => [
                'headingOptions' => ['class' => 'box-header'],
                'heading' => '<h1>' . Html::encode($this->title) . '</h1>',
            ],
            'toolbar' => [
                $fullExportMenu
            ],
            'containerOptions' => ['class' => 'box-body']
        ]);
        ?>
    </div>
</div>
