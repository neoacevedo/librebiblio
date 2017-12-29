<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\reports\AcquisitionsSearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app/reports', 'Acquisitions');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;

$materialType = backend\models\MaterialType::find()->all();
$collection = \backend\models\Collection::find()->all();
?>

<div class="acquisitions-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['results', 'type' => $model->formName()],
                'method' => 'get',
    ]);
    ?>

    <div class="row">
        <div class="col-xs-4">&nbsp;</div>
        <div class="col-xs-4">
            <?= $form->field($model, 'created_at')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd']) ?>
        </div>
        <div class="col-xs-4">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-xs-4">&nbsp;</div>
        <div class="col-xs-4">
            <?= $form->field($model, 'author') ?>
        </div>
        <div class="col-xs-4">&nbsp;</div>
    </div>

    <div class="row">
        <div class="col-xs-4">&nbsp;</div>
        <div class="col-xs-4">
            <?= $form->field($model, 'collection')->dropDownList(\yii\helpers\ArrayHelper::map($collection, 'id', 'description')) ?>
        </div>
        <div class="col-xs-4">&nbsp;</div>
    </div>
    
    <div class="row">
        <div class="col-xs-4">&nbsp;</div>
        <div class="col-xs-4">
            <?= $form->field($model, 'Material')->dropDownList(\yii\helpers\ArrayHelper::map($materialType, 'id', 'description')) ?>
        </div>
        <div class="col-xs-4">&nbsp;</div>
    </div>

    <div class="form-group">
        <div class="col-xs-5">&nbsp;</div>
        <div class="col-xs-3">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
        </div>
        <div class="col-xs-4">&nbsp;</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
