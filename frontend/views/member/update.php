<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => 'profile'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

