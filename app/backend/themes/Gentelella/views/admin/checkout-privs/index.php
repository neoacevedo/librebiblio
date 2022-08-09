<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CheckoutPrivsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('checkout', 'Checkout Privs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkout-privs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <p>
            <?= Html::a(Yii::t('checkout', 'Create Checkout Privs'), ['create'], ['class' => 'btn btn-success']) ?>
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
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                    'options' => ['class' => 'table table-striped table-bordered table-responsive']
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
