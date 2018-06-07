<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\reports\CheckoutsSearch */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app/reports', 'Bibliography Checkout Listing');
$this->params['breadcrumbs'][] = ['label' => Yii::t("app/reports", "Reports"), 'url' => ["admin/report/index"]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="checkouts-search">
    <h1><?= $this->title ?></h1>
    <?php
    $form = ActiveForm::begin([
                'action' => ['view', 'type' => $model->formName()],
                'method' => 'get',
                'options' => [
                    'data-pjax' => 1
                ],
    ]);
    ?>

    <?php // echo $form->field($model, 'barcode_nmbr') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php echo $form->field($model, 'due_back_dt')->widget(DatePicker::class, ['dateFormat' => 'yyyy-MM-dd']) ?>

    <?php echo $form->field($model, 'status_begin_dt')->widget(DatePicker::class, ['dateFormat' => 'yyyy-MM-dd']) ?>

    <?php // echo $form->field($model, 'pin') ?>

        <?php // echo $form->field($model, 'name')  ?>

    <div class="form-group">
<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
