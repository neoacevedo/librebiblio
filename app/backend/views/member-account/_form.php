<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MemberAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-account-form">

    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>

            <?php echo $form->field($model, 'transaction_type_cd')->dropDownList(\yii\helpers\ArrayHelper::map($transactionType, 'code', 'description')); ?>

            <?= $form->field($model, 'amount')->textInput(['type' => 'number', 'min' => 1, 'maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

            <div class="hidden">
                <?= $form->field($model, 'create_userid')->hiddenInput(['value' => \Yii::$app->user->id])->label("") ?>
                <?= $form->field($model, 'mbr_id')->hiddenInput(['value' => Yii::$app->request->queryParams['mbr_id']])->label("") ?>
                <?= $form->field($model, 'created_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label("") ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
