<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MemberAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'create_userid')->textInput() ?>

    <?= $form->field($model, 'transaction_type_cd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('circulation', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
