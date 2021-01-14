<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Settings $model */
/** @var yii\widgets\ActiveForm $form */


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

    <?php $form = ActiveForm::begin([
        'action' => ['admin/settings/library-settings-update'],
        'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>

    <?= $form->field($model, "library_name") ?>

    <?=
    $form->field($model, 'library_image_url')->dropDownList($files, ['id' => 'file_list', 'class' => 'form-control'])
    ?>

    <?= Html::fileInput('imageFile', '', ['id' => 'file', 'style' => ['display' => 'none']]) ?>

    <div class="checkbox">
        <?= $form->field($model, "use_image_flg")->checkbox(['value' => 1]) ?>
    </div>

    <?= $form->field($model, "library_hours")->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, "library_phone")->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, "purge_history_after_months")->textInput(['type' => 'number']) ?>

    <?= $form->field($model, "block_checkouts_when_fines_due")->dropDownList(['Y' => Yii::t('app', 'Yes'), 'N' => Yii::t('app', 'No')]) ?>

    <?= $form->field($model, "hold_max_days")->textInput(['type' => 'number']) ?>

    <?= $form->field($model, "items_per_page")->textInput(['type' => 'number']) ?>

    <?= $form->field($model, "offline")->dropDownList(['1' => Yii::t('app', 'Yes'), '0' => Yii::t('app', 'No')]) ?>

    <fieldset>
        <legend><?= Yii::t("app", "Advanced") ?></legend>
        <?= $form->field($model, "cache_handler")->dropDownList(["file" => Yii::t("app", "File"), "memcached" => "Memcached", "dummy" => "Dummy"]) ?>
    </fieldset>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['admin/settings'], ['class' => 'btn btn-default']) ?>
    </div>

    <div class="hidden">
        <?= $form->field($model, 'created_at')->label('')->hiddenInput(['value' => ($model->created_at === null) ? date('Y-m-d H:i:s') : $model->created_at]) ?>
        <?= $form->field($model, 'updated_at')->label('')->hiddenInput(['value' => date("Y-m-d H:i:s")]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>