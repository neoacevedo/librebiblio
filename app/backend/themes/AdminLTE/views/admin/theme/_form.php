<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Theme */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="theme-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?php
    if (count($skins) > 0):
        ?>
    <?= $form->field($model, 'skin')->dropDownList($skins, ['class' => 'form-control']) ?>
    <?php
    endif;
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>