<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biblio-search">
    <?php
    $form = ActiveForm::begin([
                'action' => ['search'],
                'method' => 'get',
                'options' => ['class' => 'form']
    ]);
    ?>
    <div class="form-row">
        <div class="col-1">&nbsp;</div>
        <div class="col">
            <input id="input_search" name="BiblioSearch[title]" class="form-control" />
            <input type="hidden" name="BiblioSearch[opac_flg]" value="1" />
        </div>
        <div class="col-1">&nbsp;</div>
    </div>
    <div class="form">&nbsp;</div>
    <div class="form-row">
        <div class="col">&nbsp;</div>
        <div class="col text-center">
            <button type="submit" name="search_opt" title="" value="BiblioSearch[title]"
                class="btn btn-lg btn-light biblio"> <?= Yii::t('app', 'Title') ?></button>
            &nbsp;
            <button type="submit" name="search_opt" value="BiblioSearch[author]" class="btn btn-lg btn-light biblio">
                <?= Yii::t('app', 'Author') ?></button>
        </div>
        <div class="col">&nbsp;</div>
    </div>
    <?php
    ActiveForm::end();
    ?>

</div>
<div class="row">&nbsp;</div>