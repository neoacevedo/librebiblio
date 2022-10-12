<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioCopy */
/* @var $form yii\widgets\ActiveForm */
/** @var array $biblio_status */
?>

<div class="biblio-copy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'barcode_nmbr')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::checkbox('autoqrcode', false, ['id' => 'autoqrcode'])  ?>
        <label for="autoqrcode"><?= Yii::t("cataloging", "Autogenerate") ?></label>
    </div>

    <?= $form->field($model, 'copy_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_cd')->dropDownList(\yii\helpers\ArrayHelper::map($biblio_status, 'code', 'description'), [
        'disabled' => $model->status_cd === 'out' ? true : false
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <div class="d-none">
        <?= $form->field($model, 'bibid')->hiddenInput(['value' => Yii::$app->request->get('bibid')])->label('') ?>
        <?= $form->field($model, 'status_begin_dt')->label('')->hiddenInput(['value' => date('Y-m-d H:i:s')]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>