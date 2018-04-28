<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioField */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biblio-field-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bibid')->textInput() ?>

    <?= $form->field($model, 'tag')->textInput() ?>

    <?= $form->field($model, 'ind1_cd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ind2_cd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subfield_cd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field_data')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cataloging', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div> 
