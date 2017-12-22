<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Account');
?>
<div class="member-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

