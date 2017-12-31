<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/reports', 'Report');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;

// take just first model in the list
$model = $dataProvider->models[0];
if (count($model) > 0) {
    
    $attributes = array_merge([
        ['class' => 'yii\grid\SerialColumn']], array_keys($model->attributes)
    );
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
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $attributes,
        'options' => ['class' => 'table table-striped table-bordered table-responsive']
    ])
    ?>
</div>
