<?php

use backend\reports\Checkouts;
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
                'barcode_nmbr',
                'title',
                'author',
                'pin',
                'member_name',
                'status_begin_dt',
                'due_back_dt'
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
                'id',
                'barcode_nmbr',
                'title',
                'author',
                'pin',
                'member_name',
                'status_begin_dt',
                'due_back_dt'
            ],
            'panel' => [
                'headingOptions' => ['class' => 'card-header'],
                'heading' => Html::encode(Yii::t('app/reports', $searchModel->getName())),
            ],
            'toolbar' => [
                $fullExportMenu
            ],
            'containerOptions' => ['class' => 'card-body']
        ]);
        ?>
    </div>
</div>