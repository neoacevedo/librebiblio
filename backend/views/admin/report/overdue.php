<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\reports\OverdueSearch */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app/reports', 'Over Due Member List');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="overdue-search">
    <h1><?= $this->title ?></h1>
    <?php
    $form = ActiveForm::begin([
                'action' => ['results', 'type' => $model->formName()],
                'method' => 'get',
    ]);
    ?>

    <?php // echo $form->field($searchModel, 'title') ?>

    <?php // echo $form->field($searchModel, 'author')  ?>
    <div class="row">
        <div class="col-xs-4">&nbsp;</div>
        <div class="col-xs-4">
            <?php echo $form->field($model, 'due_back_dt')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd']) ?>
        </div>
        <div class="col-xs-4">&nbsp;</div>
    </div>
    <?php // echo $form->field($model, 'status_begin_dt') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'days_late')  ?>

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
