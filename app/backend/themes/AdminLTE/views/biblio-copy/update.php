<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioCopy */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Biblio Copy',
        ]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('biblio', 'Biblio Copies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->barcode_nmbr, 'url' => ['view', 'id' => $model->id, 'bibid' => $model->bibid]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="biblio-copy-update">
    <div class="card">
        <div class="card-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
?>
        </div>
    </div>
</div>