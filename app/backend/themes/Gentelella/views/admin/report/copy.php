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
    <div class="card">
        <div class="card-body">
            <?php
            $form = ActiveForm::begin([
                        'action' => ['view', 'type' => $model->formName()],
                        'method' => 'get',
            ]);
            ?>

            <div class="form-row">
                <div class="col">&nbsp;</div>
                <div class="col">
                    <?php echo $form->field($model, 'barcode_nmbr')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col">&nbsp;</div>
            </div>

            <div class="form-row">
                <div class="col">&nbsp;</div>
                <div class="col">
                    <?= $form->field($model, 'created_at')->textInput(['pattern' => '\d{4}-\d{2}-\d{2}', 'type' => 'date']) ?>
                </div>
                <div class="col">&nbsp;</div>
            </div>

            <?php // echo $form->field($model, 'status_cd')?>

            <?php // echo $form->field($model, 'status_begin_dt')?>

            <?php // echo $form->field($model, 'due_back_dt')?>

            <?php // echo $form->field($model, 'mbr_id')?>

            <?php // echo $form->field($model, 'renewal_count')?>

            <?php // echo $form->field($model, 'callno')?>

            <?php // echo $form->field($model, 'title')?>

            <?php // echo $form->field($model, 'author')?>

            <?php // echo $form->field($model, 'collection')?>

            <div class="form-group">
                <div class="col">&nbsp;</div>
                <div class="col">
                    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
                </div>
                <div class="col">&nbsp;</div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>