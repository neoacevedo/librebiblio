<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Update {modelClass} : ', [
            'modelClass' => Yii::t('app', 'Member'),
        ]) . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['/circulation/index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['member/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="box">
        <div class="box-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>
