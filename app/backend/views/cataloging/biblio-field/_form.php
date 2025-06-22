<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Dropdown;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/** @var \common\models\BiblioField $model */
/** @var \common\models\Usmarc[] $marcBlocks */
/* @var $biblio common\models\Biblio */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="biblio-field-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-row">
        <div class="col-4">
            <label for="bibliofield-tag" class="form-label"><?= $model->getAttributeLabel("tag") ?></label>
            <select class="form-control" name="BiblioField[tag]" id="bibliofield-tag" aria-required="true" required>
                <option value="">--</option>
                <?php foreach($marcBlocks as $block): ?>
                <optgroup
                    label="<?= $block->block_mbr . " - " . $block->description ?>">
                    <?php foreach($block->usmarcTags as $tag): ?>
                <optgroup
                    label="&nbsp;<?= $tag->tag . " - " . $tag->description ?>">
                    <?php foreach($tag->usmarcSubfields as $subfield): ?>
                    <option value="<?= $subfield->subfield_cd ?>">
                        <?= $subfield->subfield_cd . " - " . $subfield->description ?>
                    </option>
                    <?php endforeach; ?>
                </optgroup>
                <?php endforeach; ?>
                </optgroup>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <?= $form->field($model, 'subfield_cd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field_data')->textInput(['maxlength' => true]) ?>

    <div class="d-none">
        <?= $form->field($model, 'ind1_cd')->hiddenInput(['value' => 'N'])->label('') ?>
        <?= $form->field($model, 'ind2_cd')->hiddenInput(['value' => 'N'])->label('') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>