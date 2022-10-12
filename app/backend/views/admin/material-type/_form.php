<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MaterialType */
/* @var $form yii\widgets\ActiveForm */
/** @var array $material_type_list */
/** @var neoacevedo\yii2\storage\models\FileManager $fileModel */
?>

<div class="material-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-row">
        <div class="col">
            <?= $form->field($model, 'icon')->dropDownList($material_type_list)->label(Yii::t('app', 'Icon')) ?>
        </div>

        <div class="col">
            <?= $form->field($fileModel, 'uploadedFile')->fileInput(['class' => 'form-control'])->label(Yii::t('app', 'Image File')) ?>
        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['admin/settings'], ['class' => 'btn btn-default']) ?>
        <div class="hidden">
            <?= $form->field($model, 'default_flg')->input('hidden', ['value' => 'N'])->label('') ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>