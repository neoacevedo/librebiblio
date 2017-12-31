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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?=
        SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => Yii::t('app', 'Options'),
            'headingOptions' => ['class' => 'head-style'],
            'items' => [
                ['label' => Yii::t('app/settings', 'Library Settings'), 'url' => ['admin/settings/library-settings'], 'icon' => 'wrench'],
                ['label' => Yii::t('app/settings', 'Material Types'), 'url' => ['admin/material-type/index'], 'icon' => 'tags'],
                ['label' => Yii::t('app/settings', 'Collections'), 'url' => ['admin/collections/index'], 'icon' => 'folder-open'],
                ['label' => Yii::t('app/settings', 'Member Classify'), 'url' => ['admin/member-classify/index'], 'icon' => 'user'],
                ['label' => Yii::t('app/settings', 'Checkout Privileges'), 'url' => ['admin/checkout-privs/index'], 'icon' => 'check'],
                ['label' => Yii::t('app/settings', 'Themes'), 'url' => ['admin/themes'], 'icon' => 'adjust']
            ],
        ]);
        ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <p>
            <?= Html::a(Yii::t('checkout', 'Create Checkout Privs'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
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
