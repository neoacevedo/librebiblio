<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\reports\CheckoutStatsSearch */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app/reports', 'Periodic Checkout Count');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="checkout-stats-search">
    <div class="card">
        <div class="card-body">
            <?php
            $form = ActiveForm::begin([
                        'action' => ['view', 'type' => $model->formName()],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => 1
                        ],
            ]);
            ?>

            <div class="form-group">
                <?= Html::label(Yii::t('app/reports', 'Time Span')) ?>
                <?php
                echo Html::dropDownList(
                "timespan",
                null,
                ['w' => Yii::t('app/reports', 'Week'), 'm' => Yii::t('app/reports', 'Month'), 'q' => Yii::t('app/reports', 'Quarter')],
                ['class' => 'form-control']
            )
                ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>