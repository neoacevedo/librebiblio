<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Theme */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="theme-form">

    <?php $form = ActiveForm::begin([
        'action' => ['/admin/theme/create'],
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'themeFile')->fileInput(['required' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>