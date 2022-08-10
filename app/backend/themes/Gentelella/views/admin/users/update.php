<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'User',
        ]) . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['users']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['users-view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="user-update">
    <div class="box">
        <div class="box-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="box-body">

            <?=
            $this->render('_form', [
                'model' => $model,
                'isNewRecord' => false
            ])
            ?>
        </div>
    </div>
</div>
