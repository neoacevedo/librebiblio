<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username') ?>

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

    <?= $form->field($model, 'phone')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([\backend\models\User::STATUS_BLOCKED => Yii::t('app', 'Blocked'), \backend\models\User::STATUS_ACTIVE => Yii::t('app', 'Active')]) ?>
    <div class="hidden">
        <?= !$isNewRecord ?: $form->field($model, 'password')->hiddenInput(['value' => $model->generateUniqueRandomString(12)])->label('') ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton($isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
