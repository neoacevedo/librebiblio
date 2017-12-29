<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Theme */

$this->title = Yii::t('app/themes', 'Update {modelClass}: ', [
            'modelClass' => 'Theme',
        ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/themes', 'Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;#['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
#$this->params['breadcrumbs'][] = Yii::t('app/themes', 'Update');
?>
<div class="theme-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="box">
        <div class="box-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                'skins' => $skins
            ])
            ?>
        </div>
    </div>
</div>
