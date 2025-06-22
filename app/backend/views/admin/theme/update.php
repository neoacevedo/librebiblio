<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Theme */

$this->title = Yii::t('app/theme', 'Update {modelClass}: ', [
            'modelClass' => 'Theme',
        ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/theme', 'Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name; // ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
?>
<div class="theme-update">
    <div class="card">
        <div class="card-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                'skins' => $skins
            ])
            ?>
        </div>
    </div>
</div>