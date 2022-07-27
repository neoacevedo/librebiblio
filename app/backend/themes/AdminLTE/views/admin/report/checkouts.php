<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\reports\CheckoutsSearch */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app/reports', 'Bibliography Checkout Listing');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="checkouts-search">
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

            <?php // echo $form->field($model, 'barcode_nmbr')?>

            <?php // echo $form->field($model, 'title')?>

            <?php // echo $form->field($model, 'author')?>

            <div class="form-row">
                <div class="col">
                    <?php echo $form->field($model, 'due_back_dt')->textInput(['pattern' => '\d{4}-\d{2}-\d{2}', 'type' => 'date']) ?>
                </div>
                <div class="col">
                    <?php echo $form->field($model, 'status_begin_dt')->textInput(['pattern' => '\d{4}-\d{2}-\d{2}', 'type' => 'date']) ?>
                </div>
            </div>

            <?php // echo $form->field($model, 'pin')?>

            <?php // echo $form->field($model, 'name')?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>