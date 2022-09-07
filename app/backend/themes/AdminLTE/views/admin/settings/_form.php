<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Settings $model */
/** @var yii\widgets\ActiveForm $form */
/** @var neoacevedo\yii2\storage\models\FileManager $fileModel */

$js = <<<JAVASCRIPT
(function() {
    document.getElementById("library_img").src = $('#file_list').val();
    $('#file_list').on('change', function(e) {
        if($(this).val() == 1) {
            $('#file').show();
        } else {
            $('#file').hide();
            document.getElementById("library_img").src = $(this).val();
        }
    });
})();

JAVASCRIPT;
$this->registerJs($js);
?>

<div class="settings-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]);
?>

    <?= $form->field($model, "library_name") ?>
    <div class="form-row">
        <div class="col-2">
            <img id="library_img" src="" class="img img-thumbnail img-responsive">
        </div>
        <div class="col">
            <?= $form->field($model, 'library_image_url')->dropDownList($files, ['id' => 'file_list', 'class' => 'form-control']) ?>
        </div>
    </div>
    <?= $form->field($fileModel, 'uploadedFile')->fileInput(['id' => 'file', 'class' => 'form-control', 'style' => ['display' => 'none']])->label("") ?>

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
        <legend><?= Yii::t("app", "Advanced") ?>
        </legend>
        <?= $form->field($model, "cache_handler")->dropDownList(["yii\\caching\\FileCache" => Yii::t("app", "File"), "yii\\caching\\ApcCache" => "APC", "yii\\caching\\DummyCache" => "Dummy"]) ?>
    </fieldset>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('yii', 'Update'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['admin/settings'], ['class' => 'btn btn-default']) ?>
    </div>

    <div class="hidden">
        <?= $form->field($model, 'created_at')->label('')->hiddenInput(['value' => ($model->created_at === null) ? date('Y-m-d H:i:s') : $model->created_at]) ?>
        <?= $form->field($model, 'updated_at')->label('')->hiddenInput(['value' => date("Y-m-d H:i:s")]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>