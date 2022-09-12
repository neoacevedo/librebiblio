<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioField */
/* @var $marcBlocks marcBlocks */
/* @var $biblio common\models\Biblio */
/* @var $form yii\widgets\ActiveForm */

$blockKey = ArrayHelper::map(array_merge([''], array_values($marcBlocks)), 'block_mbr', 'description');
?>

<div class="biblio-field-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">

        <?= $form->field($model, 'subfield_cd')->dropDownList([]) ?>

        <?= $form->field($model, 'field_data')->textInput(['maxlength' => true]) ?>

        <div class="d-none">
            <?= $form->field($model, 'ind1_cd')->hiddenInput(['value' => 'N'])->label('') ?>
            <?= $form->field($model, 'ind2_cd')->hiddenInput(['value' => 'N'])->label('') ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>