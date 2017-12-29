<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\reports\Acquisitions */

$this->title = Yii::t('app/reports', 'Create Acquisitions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/reports', 'Acquisitions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acquisitions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
