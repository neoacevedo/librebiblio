<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $biblio common\models\Biblio */
/* @var $model common\models\BiblioField */
/* @var $marcBlocks marcBlocks */

$this->title = Yii::t('cataloging', 'Update Biblio Field: {nameAttribute}', [
            'nameAttribute' => $model->bibid,
        ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['cataloging/biblio/index']];
$this->params['breadcrumbs'][] = ['label' => $biblio->title, 'url' => ['cataloging/biblio/view', 'id' => $biblio->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-field-update">
    <div class="box">
        <div class="box-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="box-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                'biblio' => $biblio,
                'marcBlocks' => $marcBlocks
            ])
            ?>
        </div>
    </div>

</div>
