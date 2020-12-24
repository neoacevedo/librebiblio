<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/** @var $this yii\web\View */
/** @var backend\reports\AcquisitionsSearch $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array|ActiveRecord[] $materialType */
/** @var array|ActiveRecord[] $collection */

$this->title = Yii::t('app/reports', 'Acquisitions');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;

$materials = \yii\helpers\ArrayHelper::map($materialType, 'description', 'description');
$materials = array_merge([" " => ""], $materials);

$collections = \yii\helpers\ArrayHelper::map($collection, 'description', 'description');
$collections = array_merge([' ' => ''], $collections);
?>

<div class="acquisitions-search">
    <h1><?= $this->title ?></h1>
    <div class="box">
        <div class="box-body">
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
    </div>
</div>
