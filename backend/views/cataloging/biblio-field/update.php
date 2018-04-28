<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioField */

$this->title = Yii::t('cataloging', 'Update Biblio Field: {nameAttribute}', [
    'nameAttribute' => $model->bibid,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('cataloging', 'Biblio Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bibid, 'url' => ['view', 'bibid' => $model->bibid, 'fieldid' => $model->fieldid]];
$this->params['breadcrumbs'][] = Yii::t('cataloging', 'Update');
?>
<div class="biblio-field-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
