<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\reports\ItemHistorySearch */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app/reports', 'Item Checkout History');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="item-history-search">
    <h1><?= $this->title ?></h1>
    <?php
    $form = ActiveForm::begin([
                'action' => ['view', 'type' => $model->formName()],
                'method' => 'get',
                'options' => [
                    'data-pjax' => 1
                ],
    ]);
    ?>

    <?= $form->field($model, 'call_num') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'member') ?>

    <?php // echo $form->field($model, 'checkout') ?>

    <?php // echo $form->field($model, 'due')  ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
