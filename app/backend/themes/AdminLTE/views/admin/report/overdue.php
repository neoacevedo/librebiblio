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
    <div class="card">
        <div class="card-body">
            <?php
            $form = ActiveForm::begin([
                        'action' => ['view', 'type' => $model->formName()],
                        'method' => 'get',
            ]);
            ?>

            <?php // echo $form->field($searchModel, 'title')?>

            <?php // echo $form->field($searchModel, 'author')?>
            <div class="row">
                <div class="col">&nbsp;</div>
                <div class="col">
                    <?php echo $form->field($model, 'due_back_dt')->textInput(['pattern' => '\d{4}-\d{2}-\d{2}', 'type' => 'date']) ?>
                </div>
                <div class="col">&nbsp;</div>
            </div>
            <?php // echo $form->field($model, 'status_begin_dt')?>

            <?php // echo $form->field($model, 'name')?>

            <?php // echo $form->field($model, 'days_late')?>

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