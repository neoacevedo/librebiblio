<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MemberClassify */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-classify-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_fines')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['admin/settings'], ['class' => 'btn btn-default']) ?>
        <div class="hidden">
            <?= $form->field($model, 'default_flg')->input('hidden', ['value' => 'N'])->label('') ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>