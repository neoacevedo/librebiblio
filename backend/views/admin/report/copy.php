<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\reports\CopySearch */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app/reports', 'Copy Search');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="copy-search">
    <h1><?= $this->title ?></h1>
    <?php
    $form = ActiveForm::begin([
                'action' => ['view', 'type' => $model->formName()],
                'method' => 'get',
    ]);
    ?>

    <div class="row">
        <div class="col-xs-5">&nbsp;</div>
        <div class="col-xs-2">
            <?php echo $form->field($model, 'barcode_nmbr')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-xs-5">&nbsp;</div>
    </div>

    <div class="row">
        <div class="col-xs-5">&nbsp;</div>
        <div class="col-xs-2">
            <?= $form->field($model, 'created_at')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd']) ?>
        </div>
        <div class="col-xs-5">&nbsp;</div>
    </div>

    <?php // echo $form->field($model, 'status_cd')  ?>

    <?php // echo $form->field($model, 'status_begin_dt')  ?>

    <?php // echo $form->field($model, 'due_back_dt')  ?>

    <?php // echo $form->field($model, 'mbr_id')  ?>

    <?php // echo $form->field($model, 'renewal_count')  ?>

    <?php // echo $form->field($model, 'callno')  ?>

    <?php // echo $form->field($model, 'title')  ?>

    <?php // echo $form->field($model, 'author')  ?>

    <?php // echo $form->field($model, 'collection')   ?>

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
