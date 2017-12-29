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

    <?php $form = ActiveForm::begin([
        'action' => ['results', 'type' => $model->formName()],
        'method' => 'get',
    ]); ?>


    <?php // echo $form->field($searchModel, 'title') ?>

    <?php // echo $form->field($searchModel, 'author') ?>

    <?php echo $form->field($model, 'due_back_dt')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd']) ?>

    <?php // echo $form->field($model, 'status_begin_dt') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'days_late') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
