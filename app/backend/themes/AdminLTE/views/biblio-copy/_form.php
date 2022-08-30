<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioCopy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biblio-copy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'barcode_nmbr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'copy_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_cd')->dropDownList(\yii\helpers\ArrayHelper::map(common\models\BiblioStatusDm::find()->all(), 'code', 'description')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <div class="d-none">
        <?= $form->field($model, 'bibid')->hiddenInput(['value' => Yii::$app->request->get('bibid')])->label('') ?>
        <?= $form->field($model, 'created_at')->label('')->hiddenInput(['value' => ($model->created_at === null) ? date('Y-m-d H:i:s') : $model->created_at]) ?>
        <?= $form->field($model, 'updated_at')->label('')->hiddenInput(['value' => date("Y-m-d H:i:s")]) ?>
        <?= $form->field($model, 'status_begin_dt')->label('')->hiddenInput(['value' => date('Y-m-d H:i:s')]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>