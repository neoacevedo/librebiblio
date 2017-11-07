<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MaterialType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="material-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php #$form->field($model, 'image_file')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'image_file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['admin/settings'], ['class' => 'btn btn-default']) ?>
        <div class="hidden">
            <?= $form->field($model, 'default_flg')->input('hidden', ['value' => 'N'])->label('') ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
