<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\BiblioField $model */
/** @var ActiveForm $form */
?>
<div class="biblio-field-bulk-create">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'bibid') ?>
        <?= $form->field($model, 'tag') ?>
        <?= $form->field($model, 'subfield_cd') ?>
        <?= $form->field($model, 'field_data') ?>
        <?= $form->field($model, 'ind1_cd') ?>
        <?= $form->field($model, 'ind2_cd') ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- biblio-field-bulk-create -->
