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
    <?= $form->field($model, 'frontend')->dropDownList([1 => Yii::t("app", "Frontend"), 0 => Yii::t('app', 'Backend')]) ?>

    <?= $form->field($model, 'active')->dropDownList([1 => Yii::t("app", "Yes"), 0 => Yii::t('app', 'No')]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
