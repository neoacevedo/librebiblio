<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/** @var common\models\Member $model */
/* @var $form yii\widgets\ActiveForm */

$mbr_classify = Yii::$app->db->createCommand("Select * from {{%mbr_classify_dm}}")->queryAll();
?>

<div class="user-form">
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['id' => 'form-signup']]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <div class="form-row">
                <div class="col">
                    <?= $form->field($model, 'first_name')->textInput(['class' => 'form-control mb-6']) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'last_name')->textInput(['class' => 'form-control mb-6']) ?>
                </div>
            </div>

            <div class="form-row">
                <div class="col">
                    <?= $form->field($model, 'address') ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'email') ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'phone')->textInput() ?>
                </div>
            </div>

            <div class="form-row">
                <div class="col">
                    <?= $form->field($model, 'pin')->input('number', ['min' => 1]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'classification_id')->dropDownList(\yii\helpers\ArrayHelper::map($mbr_classify, 'id', 'description')) ?>
                </div>
            </div>

            <div class="d-none">
                <?= $form->field($model, 'password')->hiddenInput(['value' => Yii::$app->security->generateRandomString(16)])->label('') ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t("app", 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>