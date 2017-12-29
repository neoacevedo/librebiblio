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

    <?php
    $form = ActiveForm::begin([
                'action' => ['results', 'type' => $searchModel->formName()],
                'method' => 'get',
    ]);
    ?>

    <div class="row">
        <div class="col-xs-5">&nbsp;</div>
        <div class="col-xs-2">
            <?php echo $form->field($searchModel, 'barcode_nmbr')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-xs-5">&nbsp;</div>
    </div>

    <div class="row">
        <div class="col-xs-5">&nbsp;</div>
        <div class="col-xs-2">
            <?= $form->field($searchModel, 'created_at')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd']) ?>
        </div>
        <div class="col-xs-5">&nbsp;</div>
    </div>

    <?php // echo $form->field($searchModel, 'status_cd')  ?>

    <?php // echo $form->field($searchModel, 'status_begin_dt')  ?>

    <?php // echo $form->field($searchModel, 'due_back_dt')  ?>

    <?php // echo $form->field($searchModel, 'mbr_id')  ?>

    <?php // echo $form->field($searchModel, 'renewal_count')  ?>

    <?php // echo $form->field($searchModel, 'callno')  ?>

    <?php // echo $form->field($searchModel, 'title')  ?>

    <?php // echo $form->field($searchModel, 'author')  ?>

    <?php // echo $form->field($searchModel, 'collection')   ?>

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
