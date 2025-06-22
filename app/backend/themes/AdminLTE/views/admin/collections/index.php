<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CollectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Collections');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-index">
    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
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
                        'id',
                        'description',
                        'days_due_back',
                        'daily_late_fee',
                        ['class' => 'yii\grid\ActionColumn', 'template' => "{update}&nbsp;{delete}"],
                    ],
                    'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ]) ?>
        </div>
    </div>
</div>
