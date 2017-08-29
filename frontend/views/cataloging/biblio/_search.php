<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biblio-search">    
    <div class="col-lg-12 col-md-12 col-sm-12"> 
        <div class="col-lg-2 col-md-2 col-sm-2"></div>
        <div class="col-lg-8 col-md-8 col-sm-8">
            <?php
            $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                        'options' => ['class' => 'form-inline']
            ]);
            ?>
            <input id="input_search" name="BiblioSearch[title]" class="form-control" style="width: 66.66666667%" />
            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-search"></i></button>
            <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
            <?php
            ActiveForm::end();
            ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2"></div>
    </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>
