<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioCopy */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Biblio Copy',
        ]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('biblio', 'Biblio Copies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->barcode_nmbr, 'url' => ['view', 'id' => $model->id, 'bibid' => $model->bibid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="biblio-copy-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="box">
        <div class="box-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>
