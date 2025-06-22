<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Collection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="collection-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'days_due_back')->textInput(['type' => 'number', 'step' => 1]) ?>

    <?= $form->field($model, 'daily_late_fee')->textInput(['maxlength' => true, 'type' => 'number', 'step' => 0.01]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['admin/settings'], ['class' => 'btn btn-default']) ?>
        <div class="hidden">
            <?= $form->field($model, 'default_flg')->input('hidden', ['value' => 'N']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>