<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $model common\models\CheckoutPrivs */

$this->title = $model->materialType->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Collections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('checkout', 'Checkout Privs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkout-privs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id, 'material_cd' => $model->material_cd, 'classification_id' => $model->classification_id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id, 'material_cd' => $model->material_cd, 'classification_id' => $model->classification_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
        <div class="box">
            <div class="box-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'materialType',
                            'value' => 'materialType.description',
                            'label' => 'Material'
                        ],
                        [
                            'attribute' => 'classification',
                            'value' => 'classification.description',
                            'label' => Yii::t('app', 'Classification')
                        ],
                        'checkout_limit',
                        'renewal_limit',
                    ],
                    'options' => ['class' => 'table table-striped table-bordered table-responsive']
                ])
                ?>
            </div>
        </div>
    </div>
</div>
