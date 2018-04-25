<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */
/* @var $form yii\widgets\ActiveForm */


#$bibliofield = backend\models\BiblioField::
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

    <?= $form->field($model, 'call_nmbr2')->textInput(['maxlength' => true])->label('') ?>

    <?= $form->field($model, 'call_nmbr3')->textInput(['maxlength' => true])->label('') ?>

    <?= $form->field($model, 'opac_flg')->checkbox() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'data-value' => '245a']) ?>

    <?= $form->field($model, 'title_remainder')->textInput(['maxlength' => true, 'data-value' => '245b']) ?>

    <?= $form->field($model, 'image_file')->fileInput() ?>
    <?=
    Html::img(Yii::$app->urlManagerFrontend->createUrl("/images/covers/{$model->image_file}"), ['alt' => $model->title,
        'title' => $model->title,
        'class' => 'image-thumbnail center-block',
        'style' => 'width: 140px'])
    ?>

    <?= $form->field($model, 'responsibility_stmt')->textInput(['maxlength' => true, 'data-value' => '245c']) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true, 'data-value' => '100a']) ?>

    <?= $form->field($model, 'topic1')->textInput(['maxlength' => true, 'data-value' => '650a']) ?>

    <?= $form->field($model, 'topic2')->textInput(['maxlength' => true, 'data-value' => '650a1']) ?>

    <?= $form->field($model, 'topic3')->textInput(['maxlength' => true, 'data-value' => '650a2']) ?>

    <?= $form->field($model, 'topic4')->textInput(['maxlength' => true, 'data-value' => '650a3']) ?>

    <?= $form->field($model, 'topic5')->textInput(['maxlength' => true, 'data-value' => '650a4']) ?>

    <!-- biblio fields -->
    <h4><?= Yii::t('app', "USMarc Fields:") ?></h4>
    <?php
    foreach ($modelBiblioFields as $index => $biblioField) :
        // se deberá establecer el  número máximo del campo repetible.
        if ($usmarc[$index]->tag == 520) {
            if ($usmarc[$index]->subfield_cd == 'a') {
                echo $form->field($biblioField, "[$index]field_data")->label($usmarc[$index]->description)->textarea(['cols' => 34, 'rows' => 4, 'data-value' => $usmarc[$index]->tag . $usmarc[$index]->subfield_cd]);
            }
        } else {
            echo $form->field($biblioField, "[$index]field_data")->label($usmarc[$index]->description)->textInput(['data-value' => $usmarc[$index]->tag . $usmarc[$index]->subfield_cd]);
        }
        ?>
        <div class="hidden">
            <?= $form->field($biblioField, "[$index]fieldid")->label("")->hiddenInput(); ?>
            <?= $form->field($biblioField, "[$index]tag")->label("")->hiddenInput(['value' => $usmarc[$index]->tag]); ?>
            <?= $form->field($biblioField, "[$index]subfield_cd")->label("")->hiddenInput(['value' => $usmarc[$index]->subfield_cd]); ?>
        </div>
        <?php
    endforeach;
    ?>

    <!-- // -->
    <div class="hidden">
        <?= $form->field($model, 'updated_userid')->label('')->hiddenInput(['value' => \Yii::$app->user->id]) ?>
        <?= $form->field($model, 'created_at')->label('')->hiddenInput(['value' => ($model->created_at === null) ? date('Y-m-d H:i:s') : $model->created_at]) ?>
        <?= $form->field($model, 'updated_at')->label('')->hiddenInput(['value' => date("Y-m-d H:i:s")]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>  
</div>
