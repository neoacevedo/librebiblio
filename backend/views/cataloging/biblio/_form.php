<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */
/* @var $form yii\widgets\ActiveForm */


#$bibliofield = app\models\BiblioField::
?>

<div class="biblio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'updated_userid')->label('')->hiddenInput(['value' => \Yii::$app->user->id]) ?>

    <?= $form->field($model, 'material_cd')->textInput() ?>

    <?= $form->field($model, 'collection_cd')->textInput() ?>

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
    
    <?= Html::label("Sumary", "field_data") ?>
    <?= Html::input("text", "field_data", $formBibliField->field_data, ['maxlength' => true, 'class' => 'form-control']) ?>
    
    <?php ActiveForm::end(); ?>  
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

</div>
