<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CheckoutPrivs */
/* @var $form yii\widgets\ActiveForm */
$materialType = backend\models\MaterialType::find()->all();
$classification = app\models\MemberClassify::find()->all();
?>

<div class="checkout-privs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'material_cd')->label('Material')->dropDownList(\yii\helpers\ArrayHelper::map($materialType, 'id', 'description')) ?>

    <?= $form->field($model, 'classification_id')->label(Yii::t('app', 'Member Classify'))->dropDownList(\yii\helpers\ArrayHelper::map($classification, 'id', 'description')) ?>

    <?= $form->field($model, 'checkout_limit')->input("number") ?>

    <?= $form->field($model, 'renewal_limit')->input("number") ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('checkout', 'Create') : Yii::t('checkout', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
