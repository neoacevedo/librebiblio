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
?>
<div class="collection-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="box">
        <div class="box-header">
            <div class="pull-right">
                <?php
                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $attributes
                ]);
                ?>
                <form action="">
                    <?php
                    #echo Html::dropDownList("export", NULL, ['pdf' => Yii::t('app/reports', 'Export to PDF')], ['class' => 'form-control', 'data-action' => yii\helpers\Url::to($pdfRoute)]);
                    ?>
                </form>
            </div>
        </div>
        <div class="box-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => $attributes,
                'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ]);
            ?>
        </div>
    </div>
</div>
