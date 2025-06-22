<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => 'profile'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?= $this->render('_sidenav', ['model' => $model]) ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>
    </div>
</div>

