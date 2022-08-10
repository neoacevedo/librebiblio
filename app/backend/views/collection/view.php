<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $model backend\models\MaterialType */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Material Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-type-view">

    <h1><?= Html::encode($this->title) ?>
    </h1>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <p>
            <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
?>
        </p>
        <div class="box">
            <div class="box-body">
                <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'description',
            [
                'attribute' => 'image_file',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img($model->image_file);
                }
            ],
            [
                'attribute' => 'icon',
                'format' => 'html',
                'contentOptions' => ['class' => 'align-middle'],
                'value' => function ($model) {
                    return Html::tag("span", "", ['class' => $model->icon]);
                }
            ],
        ],
        'options' => ['class' => 'table table-striped table-bordered table-responsive']
    ])
?>
            </div>
        </div>
    </div>
</div>