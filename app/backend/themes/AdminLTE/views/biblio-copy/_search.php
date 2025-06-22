<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioCopySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biblio-copy-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'bibid') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?= $form->field($model, 'copy_desc') ?>

    <?php // echo $form->field($model, 'barcode_nmbr') ?>

    <?php // echo $form->field($model, 'status_cd') ?>

    <?php // echo $form->field($model, 'status_begint_dt') ?>

    <?php // echo $form->field($model, 'due_back_dt') ?>

    <?php // echo $form->field($model, 'mbr_id') ?>

    <?php // echo $form->field($model, 'renewal_count') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
