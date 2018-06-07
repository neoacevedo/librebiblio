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
$materials = \yii\helpers\ArrayHelper::map($materialType, 'description', 'description');
$materials = array_merge([" " => ""], $materials);


$collection = \backend\models\Collection::find()->all();
$collections = \yii\helpers\ArrayHelper::map($collection, 'description', 'description');
$collections = array_merge([' ' => ''], $collections);
?>

<div class="acquisitions-search">
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
            <?= $form->field($model, 'created_at')->widget(DatePicker::class, ['dateFormat' => 'yyyy-MM-dd']) ?>
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
            <?= $form->field($model, 'collection')->dropDownList($collections) ?>
        </div>
        <div class="col-xs-4">&nbsp;</div>
    </div>
    
    <div class="row">
        <div class="col-xs-4">&nbsp;</div>
        <div class="col-xs-4">
            <?= $form->field($model, 'Material')->dropDownList($materials) ?>
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
