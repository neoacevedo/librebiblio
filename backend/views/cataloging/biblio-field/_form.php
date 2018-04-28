<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioField */
/* @var $marcBlocks marcBlocks */
/* @var $biblio common\models\Biblio */
/* @var $form yii\widgets\ActiveForm */

$blockKey = array_values($marcBlocks);
?>

<div class="biblio-field-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'tag')->dropDownList(ArrayHelper::map($blockKey, 'block_mbr', 'description'), [
        'id' => 'blockKey',
        'class' => 'form-control',
        'onchange' => '
            $.post( "index.php?r=cataloging/biblio-field/usmarc-tags-options&block=' . '"+$(this).val(), function( data ) {
                $("#tag").html(data);
            });'
    ]);
    ?>

    <div class="form-group">
        <?= Html::dropDownList('tags', null, [], [
            'id' => 'tag', 'class' => 'form-control',
            'onchange' => '
            $.post( "index.php?r=cataloging/biblio-field/usmarc-subfields-options&tag=' . '"+$(this).val(), function( data ) {
                $("#tag").html(data);
            });'
            ]) ?>
    </div>

    <?= $form->field($model, 'subfield_cd')->dropDownList([])->label('') ?>

    <?= $form->field($model, 'ind1_cd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ind2_cd')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'field_data')->textInput(['maxlength' => true]) ?>

    <div class="hidden">
<?= $form->field($model, 'bibid')->hiddenInput(['value' => $biblio->id])->label('') ?>
    </div>

    <div class="form-group">
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
