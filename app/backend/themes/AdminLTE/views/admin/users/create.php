<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Staff'), 'url' => ['admin/users']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <div class="box">
        <div class="box-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="box-body">

            <?=
            $this->render('_form', [
                'model' => $model,
                'isNewRecord' => true
            ])
            ?>
        </div>
    </div>
</div>
