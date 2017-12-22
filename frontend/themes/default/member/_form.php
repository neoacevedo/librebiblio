<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

$mbr_classify = Yii::$app->db->createCommand("Select * from {{%mbr_classify_dm}}")->queryAll();
?>

<div class="member-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3 col-xs-4">
            <?= $form->field($model, 'first_name')->textInput() ?>
        </div>
        <div class="col-md-3 col-xs-4">
            <?= $form->field($model, 'last_name')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-xs-6">
            <?= $form->field($model, 'address') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-4">
            <?= $form->field($model, 'email') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-4">
            <?= $form->field($model, 'phone')->textInput(['type' => 'number', 'min' => 100000]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-4">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
