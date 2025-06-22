<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MaterialTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Material Types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-type-index">
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
                                    'title' => Yii::t('app', 'Create Material Type'),
                                ])
                        ],
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'description',
                        [
                            'attribute' => 'image_file',
                            'format' => 'html',
                            'filter' => false,
                            'contentOptions' => ['class' => 'text-center align-middle'],
                            'value' => function ($model) {
                                return Html::img($model->image_file);
                            }
                        ],
                        [
                            'attribute' => 'icon',
                            'format' => 'html',
                            'contentOptions' => ['class' => 'text-center align-middle'],
                            'value' => function ($model) {
                                return Html::tag("span", "", ['class' => $model->icon]);
                            }
                        ],
                        ['class' => 'yii\grid\ActionColumn', 'template' => "{update}&nbsp;{delete}"],
                    ],
                    'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ]) ?>
        </div>
    </div>
</div>