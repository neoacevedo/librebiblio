<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Theme */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">&nbsp;</div>
<div class="theme-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= Html::fileInput('themeFile', '', ['id' => 'file']) ?>
    <div class="row">&nbsp;</div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="hidden">
        <?= $form->field($model, "frontend")->label("")->hiddenInput() ?>
        <?= $form->field($model, "active")->label("")->hiddenInput() ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
