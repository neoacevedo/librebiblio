<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MemberClassify */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Member Classify',
]) . $model->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Member Classifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->description, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="member-classify-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
