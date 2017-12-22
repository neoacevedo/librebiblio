<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $model backend\models\Collection */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Collections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?=
        SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => Yii::t('app', 'Options'),
            'headingOptions' => ['class' => 'head-style'],
            'items' => [
                ['label' => Yii::t('app/settings', 'Library Settings'), 'url' => ['admin/settings/library-settings'], 'icon' => 'wrench'],
                ['label' => Yii::t('app/settings', 'Material Types'), 'url' => ['admin/material-type/index'], 'icon' => 'tags'],
                ['label' => Yii::t('app/settings', 'Collections'), 'url' => ['admin/collections/index'], 'icon' => 'folder-open'],
                ['label' => Yii::t('app/settings', 'Member Classify'), 'url' => ['admin/member-classify/index'], 'icon' => 'user'],
                ['label' => Yii::t('app/settings', 'Themes'), 'url' => ['admin/themes'], 'icon' => 'adjust']
            ],
        ]);
        ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'description',
                'days_due_back',
                'daily_late_fee',
            ],
        ])
        ?>
    </div>
</div>
