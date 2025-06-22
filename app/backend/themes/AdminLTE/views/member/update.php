<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/** @var array $mbr_classify */

$this->title = Yii::t('app', 'Update {modelClass} : ', [
            'modelClass' => Yii::t('app', 'Member'),
        ]) . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['/circulation/index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['member/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="user-update">
    <?=
        $this->render('_form', [
            'model' => $model,
            'mbr_classify' => $mbr_classify
        ])
?>
</div>