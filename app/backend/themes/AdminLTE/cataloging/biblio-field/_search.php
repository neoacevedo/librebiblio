<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioFieldSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biblio-field-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bibid') ?>

    <?= $form->field($model, 'fieldid') ?>

    <?= $form->field($model, 'tag') ?>

    <?= $form->field($model, 'ind1_cd') ?>

    <?= $form->field($model, 'ind2_cd') ?>

    <?php // echo $form->field($model, 'subfield_cd') ?>

    <?php // echo $form->field($model, 'field_data') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cataloging', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('cataloging', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
