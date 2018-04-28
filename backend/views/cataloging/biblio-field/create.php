<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $biblio common\models\Biblio */
/* @var $model common\models\BiblioField */

$this->title = Yii::t('cataloging', 'Create Biblio Field');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['cataloging/biblio/index']];
$this->params['breadcrumbs'][] = ['label' => $biblio->title, 'url' => ['view', 'id' => $biblio->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-field-create">
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
