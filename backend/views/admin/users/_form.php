<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        <div class="col-xs-4">
            <?= $form->field($model, 'first_name')->textInput() ?>
        </div>
        <div class="col-xs-4">
            <?= $form->field($model, 'last_name')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'phone')->textInput(['type' => 'number', 'min' => 100000]) ?>

    <?= $form->field($model, 'status')->dropDownList([\backend\models\User::STATUS_BLOCKED => Yii::t('app', 'Blocked'), \backend\models\User::STATUS_ACTIVE => Yii::t('app', 'Active')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
