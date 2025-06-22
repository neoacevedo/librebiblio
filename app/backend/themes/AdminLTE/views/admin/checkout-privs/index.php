<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CheckoutPrivsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('checkout', 'Checkout Privs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkout-privs-index">
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
                                    'title' => Yii::t('app', 'Create Checkout Privs'),
                                ])
                        ],
                    ],
                    'columns' => [
                        'id',
                        [
                            'attribute' => 'materialType',
                            'value' => 'materialType.description',
                            'label' => 'Material'
                        ],
                        [
                            'attribute' => 'memberClassify',
                            'value' => 'memberClassify.description',
                            'label' => Yii::t('app', 'Member Classify')
                        ],
                        'checkout_limit',
                        'renewal_limit',
                        ['class' => 'yii\grid\ActionColumn', 'template' => "{update}&nbsp;{delete}"],
                    ],
                    'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ]) ?>
        </div>
    </div>
</div>