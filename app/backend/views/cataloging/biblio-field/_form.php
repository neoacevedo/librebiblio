<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioField */
/* @var $marcBlocks marcBlocks */
/* @var $biblio common\models\Biblio */
/* @var $form yii\widgets\ActiveForm */

$blockKey = ArrayHelper::map(array_merge([''], array_values($marcBlocks)), 'block_mbr', 'description');
?>

<div class="biblio-field-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <label for="block">Block</label>
        <?=
        Html::dropDownList('blocks', null, $blockKey, [
            'id' => 'block', 
            'class' => 'form-control',
            'onchange' => '
                $.post( "index.php?r=cataloging/biblio-field/usmarc-tags-options&block=' . '"+$(this).val(), function( data ) {
                $("#bibliofield-tag").html("<option value=\'\'></option>" + data);
            });'
        ])
        ?>
    </div>

    <?=
    $form->field($model, 'tag')->dropDownList([], [
        'onchange' => '
            $.post( "index.php?r=cataloging/biblio-field/usmarc-subfields-options&tag=' . '"+$(this).val(), function( data ) {
                $("#bibliofield-subfield_cd").html("<option value=\'\'></option>" + data);
            });
            '
    ])
    ?>    

    <?= $form->field($model, 'subfield_cd')->dropDownList([]) ?>

    <?= $form->field($model, 'field_data')->textInput(['maxlength' => true]) ?>

    <div class="hidden">
        <?= $form->field($model, 'bibid')->hiddenInput(['value' => $biblio->id])->label('') ?>
        <?= $form->field($model, 'ind1_cd')->hiddenInput(['value' => 'N'])->label('') ?>
        <?= $form->field($model, 'ind2_cd')->hiddenInput(['value' => 'N'])->label('') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
