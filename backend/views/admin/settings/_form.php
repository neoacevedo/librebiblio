<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioCopy */
/* @var $form yii\widgets\ActiveForm */


// emulación de data-confirm en elemento "a"
$js = "\$('#file_list').change(function(e) {
        if($(this).val() == 1) {
            $('#file').show();
            //$('#library_image_url').val('');
        } else {
            $('#file').hide();
            //$('#library_image_url').val($(this).val());
        }
    });
    /*\$('#file').change(function() {
        $('#library_image_url').val($(this).val());
    });*/";
$this->registerJs($js);
?>

<div class="settings-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, "library_name") ?>

    <?= Html::label(Yii::t('app', 'Library Image Url')) ?>
    <?=
    Html::dropDownList('file_list', $model->library_image_url, $files, ['id' => 'file_list', 'class' => 'form-control'])
    ?>

    <?= Html::fileInput('imageFile', '', ['id' => 'file', 'style' => ['display' => 'none']]) ?>
    
    <div class="checkbox">
        <?= $form->field($model, "use_image_flg")->checkbox(['value' => 'Y']) ?>
    </div>

    <?= $form->field($model, "library_hours")->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, "library_phone")->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, "purge_history_after_months")->textInput(['type' => number]) ?>

    <?= $form->field($model, "block_checkouts_when_fines_due")->dropDownList(['Y' => Yii::t('app', 'Yes'), 'N' => Yii::t('app', 'No')]) ?>

    <?= $form->field($model, "hold_max_days")->textInput(['type' => number]) ?>

    <?= $form->field($model, "offline")->dropDownList(['1' => Yii::t('app', 'Yes'), '0' => Yii::t('app', 'No')]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['admin/settings'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
