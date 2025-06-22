<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Collection */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Collection',
        ]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Collections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="collection-update">

    <h1><?= Html::encode($this->title) ?>
    </h1>
    <div class="box">
        <div class="box-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                'modelBiblioField' => $modelBiblioField
            ])
            ?>
        </div>
    </div>
</div>