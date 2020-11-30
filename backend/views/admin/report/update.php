<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\reports\Acquisitions */

$this->title = Yii::t('app/reports', 'Update {modelClass}: ', [
    'modelClass' => 'Acquisitions',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/reports', 'Acquisitions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app/reports', 'Update');
?>
<div class="acquisitions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
