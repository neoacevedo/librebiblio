<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Member */
/* @var $form yii\widgets\ActiveForm */

$mbr_classify = Yii::$app->db->createCommand("Select * from {{%mbr_classify_dm}}")->queryAll();
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-xs-4">
            <?= $form->field($model, 'first_name')->textInput() ?>
        </div>
        <div class="col-xs-4">
            <?= $form->field($model, 'last_name')->textInput() ?>
        </div>
    </div>
    
    <?= $form->field($model, 'pin')->input('number', ['min' => 1]) ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'phone')->textInput() ?>

    <?= $form->field($model, 'classification_id')->label(Yii::t('app', 'Classification'))->dropDownList(\yii\helpers\ArrayHelper::map($mbr_classify, 'id', 'description')) ?>

    <?= $form->field($model, 'status')->dropDownList([\common\models\Member::STATUS_BLOCKED => Yii::t('app', 'Blocked'), \common\models\Member::STATUS_ACTIVE => Yii::t('app', 'Active')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
