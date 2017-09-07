<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioCopy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, "library_name") ?>
    
    <?= $form->field($model, "library_image_url") ?>
    
    <?= $form->field($model, "use_image_flg") ?>
    
    <?= $form->field($model, "library_hours") ?>
    
    <?= $form->field($model, "library_phone") ?>
    
    <?= $form->field($model, "purge_history_after_months") ?>
    
    <?= $form->field($model, "block_checkouts_when_fines_due") ?>
    
    <?= $form->field($model, "hold_max_days") ?>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
