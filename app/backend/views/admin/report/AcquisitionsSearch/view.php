<?php

use backend\reports\Acquisitions;
use yii\helpers\Html;
use kartik\grid\GridView;
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
    $filename = $model[0]->name;
    if (null !== $groupBy) {
        if ($groupBy === "biblio") {
            $columns = [];
            foreach ($model[0]->attributes as $key => $value) {
                if ($key === "barcode_nmbr") {
                    continue;
                }
                $columns[$key] = $value;
            }
            $gridColumns = array_merge(
                [
                ['class' => 'kartik\grid\SerialColumn']],
                array_keys($columns)
            );
        } else {
            $gridColumns = array_merge(
                [
                ['class' => 'kartik\grid\SerialColumn']],
                array_keys($model[0]->attributes)
            );
        }
    } else {
        $columns = $searchModel->attributes;
        $gridColumns = array_merge(
            [
            ['class' => 'kartik\grid\SerialColumn']],
            array_keys($columns)
        );
    }
} else {
    $columns = $searchModel->attributes;
    $gridColumns = array_merge(
        [
        ['class' => 'kartik\grid\SerialColumn']],
        array_keys($columns)
    );

    $filename = str_replace("Search", "", Yii::$app->request->queryParams['type']);
}

$fullExportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
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
                'columns' => $gridColumns,
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