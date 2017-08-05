<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioCopy */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Biblio Copy',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblio Copies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'bibid' => $model->bibid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="biblio-copy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
