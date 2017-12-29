<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/reports', 'Results');
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
?>
<div class="collection-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-xs-4 pull-right">
            <button class="btn btn-default"><i class="glyphicon glyphicon-"></i></button>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3><?= $model->name; ?></h3>
        </div>
        <div class="box-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => $attributes,
                'options' => ['class' => 'table table-responsive']
            ]);
            ?>
        </div>
    </div>
</div>
