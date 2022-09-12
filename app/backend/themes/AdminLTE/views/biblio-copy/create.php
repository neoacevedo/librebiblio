<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioCopy */

$this->title = Yii::t('app', 'Create Biblio Copy');
$this->params['breadcrumbs'][] = ['label' => Yii::t('biblio', 'Biblio Copies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-copy-create">
    <div class="card">
        <div class="card-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                'biblio_status' => $biblio_status
            ])
?>
        </div>
    </div>
</div>