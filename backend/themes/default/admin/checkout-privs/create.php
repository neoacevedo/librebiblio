<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CheckoutPrivs */

$this->title = Yii::t('checkout', 'Create Checkout Privs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Collections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('checkout', 'Checkout Privs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkout-privs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
