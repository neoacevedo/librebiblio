<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CheckoutPrivsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="checkout-privs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'material_cd') ?>

    <?= $form->field($model, 'classification_id') ?>

    <?= $form->field($model, 'checkout_limit') ?>

    <?= $form->field($model, 'renewal_limit') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
