<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biblio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?= $form->field($model, 'updated_userid') ?>

    <?= $form->field($model, 'material_cd') ?>

    <?php // echo $form->field($model, 'collection_cd') ?>

    <?php // echo $form->field($model, 'call_nmbr1') ?>

    <?php // echo $form->field($model, 'call_nmbr2') ?>

    <?php // echo $form->field($model, 'call_nmbr3') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'title_remainder') ?>

    <?php // echo $form->field($model, 'responsibility_stmt') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'topic1') ?>

    <?php // echo $form->field($model, 'topic2') ?>

    <?php // echo $form->field($model, 'topic3') ?>

    <?php // echo $form->field($model, 'topic4') ?>

    <?php // echo $form->field($model, 'topic5') ?>

    <?php // echo $form->field($model, 'opac_flg') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
