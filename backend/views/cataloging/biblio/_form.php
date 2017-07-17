<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */
/* @var $form yii\widgets\ActiveForm */


#$bibliofield = app\models\BiblioField::
$materialType = backend\models\MaterialType::find()->all();
$collection = \backend\models\Collection::find()->all();
?>
<?php
if (Yii::$app->session->hasFlash("error")):
    ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash("error") ?>
    </div>
    <?php
endif;
?>
<div class="biblio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'material_cd')->dropDownList(\yii\helpers\ArrayHelper::map($materialType, 'id', 'description')) ?>

    <?= $form->field($model, 'collection_cd')->dropDownList(\yii\helpers\ArrayHelper::map($collection, 'id', 'description')) ?>

    <?= $form->field($model, 'call_nmbr1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'call_nmbr2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'call_nmbr3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'opac_flg')->checkbox() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_remainder')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'responsibility_stmt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'topic1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'topic2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'topic3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'topic4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'topic5')->textInput(['maxlength' => true]) ?>

    <!-- biblio field -->

    <label for='field_data[]'><?= Yii::t('app', 'Summary, etc. note:') ?></label>
    <?= $form->field($modelBiblioField, 'field_data[]')->label('')->textarea(['cols' => 35, 'rows' => 4]) ?>    

    <label for='field_data[]'><?= Yii::t('app', 'Physical description (Extent):') ?></label>
    <?= $form->field($modelBiblioField, 'field_data[]')->label('')->textInput(['maxlength' => true]) ?>    

    <label for='field_data[]'><?= Yii::t('app', 'Physical description (Other physical details):') ?></label>
    <?= $form->field($modelBiblioField, 'field_data[]')->label('')->textInput(['maxlength' => true]) ?>

    <label for='field_data[]'><?= Yii::t('app', 'Physical description (Dimensions):') ?></label>
    <?= $form->field($modelBiblioField, 'field_data[]')->label('')->textInput(['maxlength' => true]) ?>    

    <label for='field_data[]'><?= Yii::t('app', 'Physical description (Accompanying material):') ?></label>
    <?= $form->field($modelBiblioField, 'field_data[]')->label('')->textInput(['maxlength' => true]) ?>

    <label for='field_data[]'><?= Yii::t('app', 'Terms of availability:') ?></label>
    <?= $form->field($modelBiblioField, 'field_data[]')->label('')->textInput(['maxlength' => true]) ?>

    <label for='field_data[]'><?= Yii::t('app', 'Purchase price:') ?></label>
    <?= $form->field($modelBiblioField, 'field_data[]')->label('')->textInput(['type' => "number", "step" => 0.01]) ?>

    <div class="hidden">
        <!-- sumary -->
        <?= $form->field($modelBiblioField, 'tag[]')->label('')->hiddenInput(['value' => 520]) ?>
        <?= $form->field($modelBiblioField, 'subfield_cd[]')->label('')->hiddenInput(['value' => 'a']) ?>
        <?= $form->field($modelBiblioField, 'fieldid[]')->label('')->hiddenInput(['value' => 3]) ?>
        <?= $form->field($modelBiblioField, 'ind1_cd[]')->label('')->hiddenInput() ?>
        <?= $form->field($modelBiblioField, 'ind2_cd[]')->label('')->hiddenInput() ?>
        <!-- physical description ext -->
        <?= $form->field($modelBiblioField, 'tag[]')->label('')->hiddenInput(['value' => 300]) ?>
        <?= $form->field($modelBiblioField, 'subfield_cd[]')->label('')->hiddenInput(['value' => 'a']) ?>
        <?= $form->field($modelBiblioField, 'fieldid[]')->label('')->hiddenInput(['value' => 4]) ?>
        <?= $form->field($modelBiblioField, 'ind1_cd[]')->label('')->hiddenInput() ?>
        <?= $form->field($modelBiblioField, 'ind2_cd[]')->label('')->hiddenInput() ?>
        <!-- physical description other -->
        <?= $form->field($modelBiblioField, 'tag[]')->label('')->hiddenInput(['value' => 300]) ?>
        <?= $form->field($modelBiblioField, 'subfield_cd[]')->label('')->hiddenInput(['value' => 'b']) ?>
        <?= $form->field($modelBiblioField, 'fieldid[]')->label('')->hiddenInput(['value' => 5]) ?>
        <?= $form->field($modelBiblioField, 'ind1_cd[]')->label('')->hiddenInput() ?>
        <?= $form->field($modelBiblioField, 'ind2_cd[]')->label('')->hiddenInput() ?>
        <!-- physical description dimension -->
        <?= $form->field($modelBiblioField, 'tag[]')->label('')->hiddenInput(['value' => 300]) ?>
        <?= $form->field($modelBiblioField, 'subfield_cd[]')->label('')->hiddenInput(['value' => 'c']) ?>
        <?= $form->field($modelBiblioField, 'fieldid[]')->label('')->hiddenInput(['value' => 2]) ?>
        <?= $form->field($modelBiblioField, 'ind1_cd[]')->label('')->hiddenInput() ?>
        <?= $form->field($modelBiblioField, 'ind2_cd[]')->label('')->hiddenInput() ?>
        <!-- physical description accompaning material -->
        <?= $form->field($modelBiblioField, 'tag[]')->label('')->hiddenInput(['value' => 300]) ?>
        <?= $form->field($modelBiblioField, 'subfield_cd[]')->label('')->hiddenInput(['value' => 'd']) ?>
        <?= $form->field($modelBiblioField, 'fieldid[]')->label('')->hiddenInput(['value' => 5]) ?>
        <?= $form->field($modelBiblioField, 'ind1_cd[]')->label('')->hiddenInput() ?>
        <?= $form->field($modelBiblioField, 'ind2_cd[]')->label('')->hiddenInput() ?>
        <!-- terms of availability -->
        <?= $form->field($modelBiblioField, 'tag[]')->label('')->hiddenInput(['value' => 20]) ?>
        <?= $form->field($modelBiblioField, 'subfield_cd[]')->label('')->hiddenInput(['value' => 'c']) ?>
        <?= $form->field($modelBiblioField, 'fieldid[]')->label('')->hiddenInput(['value' => 7]) ?>
        <?= $form->field($modelBiblioField, 'ind1_cd[]')->label('')->hiddenInput() ?>
        <?= $form->field($modelBiblioField, 'ind2_cd[]')->label('')->hiddenInput() ?>
        <!-- purchase price -->
        <?= $form->field($modelBiblioField, 'tag[]')->label('')->hiddenInput(['value' => 541]) ?>
        <?= $form->field($modelBiblioField, 'subfield_cd[]')->label('')->hiddenInput(['value' => 'h']) ?>
        <?= $form->field($modelBiblioField, 'fieldid[]')->label('')->hiddenInput(['value' => 8]) ?>
        <?= $form->field($modelBiblioField, 'ind1_cd[]')->label('')->hiddenInput() ?>
        <?= $form->field($modelBiblioField, 'ind2_cd[]')->label('')->hiddenInput() ?>
        <!-- // -->
        <?= $form->field($model, 'updated_userid')->label('')->hiddenInput(['value' => \Yii::$app->user->id]) ?>
        <?= $form->field($model, 'created_at')->label('')->hiddenInput(['value' => ($model->created_at === null) ? date('Y-m-d H:i:s') : $model->created_at]) ?>
        <?= $form->field($model, 'updated_at')->label('')->hiddenInput(['value' => date("Y-m-d H:i:s")]) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>  
</div>
