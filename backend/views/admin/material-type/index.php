<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MaterialTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Material Types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <p>
            <?= Html::a(Yii::t('app', 'Create Material Type'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="box">
            <div class="box-body">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'description',
                        'image_file',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                    'options' => ['class' => 'table table-striped table-bordered table-responsive']
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
