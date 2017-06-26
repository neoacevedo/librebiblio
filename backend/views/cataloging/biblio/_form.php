<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biblio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_userid')->textInput() ?>

    <?= $form->field($model, 'material_cd')->textInput() ?>

    <?= $form->field($model, 'collection_cd')->textInput() ?>

    <?= $form->field($model, 'call_nmbr1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'call_nmbr2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'call_nmbr3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'title_remainder')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'responsibility_stmt')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'author')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'topic1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'topic2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'topic3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'topic4')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'topic5')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'opac_flg')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
