<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Collections');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-index">
    <div class="card">
        <div class="card-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'panel' => [
                    'type'=>'default',
                ],
                'toolbar' => [
                    [
                        'content' =>
                            Html::a('<i class="fas fa-plus"></i>', ['create'], [
                                'class' => 'btn btn-success',
                                'title' => Yii::t('app', 'Create Collection'),
                            ])
                    ],
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'description',
                    'default_flg',
                    'days_due_back',
                    'daily_late_fee',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
                'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ]);
?>
        </div>
    </div>
</div>