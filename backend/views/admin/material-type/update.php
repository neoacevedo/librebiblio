<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MaterialType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Material Type',
        ]) . $model->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Material Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->description, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="material-type-update">

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
