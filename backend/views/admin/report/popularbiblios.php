<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\reports\PopularBibliosSearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app/reports', 'Most Popular Bibliographies');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="popular-biblios-search">
    <h1><?= $this->title ?></h1>
    <?php
    $form = ActiveForm::begin([
                'action' => ['view', 'type' => $model->formName()],
                'method' => 'get',
    ]);
    ?>
    <div class="row">
        <div class="col-xs-4">&nbsp;</div>
        <div class="col-xs-4">
            <?= Html::label(Yii::t('app/reports', 'Group By')) ?>
            <?=
            Html::dropDownList("groupBy", null, ['biblio' => Yii::t('app/reports', 'Biblography'), 'copy' => Yii::t('app/reports', 'Bibliography Copy')], ['class' => 'form-control'])
            ?>
        </div>
        <div class="col-xs-4">&nbsp;</div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-xs-5">&nbsp;</div>
            <div class="col-xs-3">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
            </div>
            <div class="col-xs-4">&nbsp;</div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
