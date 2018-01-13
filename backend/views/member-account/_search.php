<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MemberAccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'mbr_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'create_userid') ?>

    <?= $form->field($model, 'transaction_type_cd') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('circulation', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('circulation', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
