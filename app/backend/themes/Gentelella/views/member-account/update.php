<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MemberAccount */

$this->title = Yii::t('circulation', 'Update Member Account: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('circulation', 'Member Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'mbr_id' => $model->mbr_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="member-account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
