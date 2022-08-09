<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CheckoutPrivs */

$this->title = Yii::t('checkout', 'Update {modelClass}: ', [
            'modelClass' => 'Checkout Privs',
        ]) . $model->materialType->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Collections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('checkout', 'Checkout Privs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->materialType->description, 'url' => ['view', 'id' => $model->id, 'material_cd' => $model->material_cd, 'classification_id' => $model->classification_id]];
$this->params['breadcrumbs'][] = Yii::t('checkout', 'Update');
?>
<div class="checkout-privs-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="box">
        <div class="box-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>
