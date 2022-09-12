<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $biblio common\models\Biblio */
/* @var $marcBlocks marcBlocks */

$this->title = Yii::t('cataloging', 'Create Biblio Field');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['cataloging/biblio/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-field-create">
    <div class="card">
        <div class="card-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                'marcBlocks' => $marcBlocks
            ])
?>
        </div>
    </div>
</div>