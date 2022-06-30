<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Theme */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="theme-form">

    <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::toRoute(["admin/theme/update", "id" => $model->id])]); ?>

    <?= $form->field($model, 'active')->label('')->dropDownList([1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')], 
            ['class' => 'form-control theme-active', 'data-formid' => "w$model->id"]) ?>
    
    <div class="hidden">
        <?= $form->field($model, 'frontend')->hiddenInput()->label("") ?>
        <?= $form->field($model, 'name')->hiddenInput()->label("") ?>
        <?= $form->field($model, 'created_at')->hiddenInput()->label("") ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
