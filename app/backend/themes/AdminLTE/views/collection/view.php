<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Collection */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Collections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-view">

    <h1><?= Html::encode($this->title) ?>
    </h1>

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
                    'default_flg',
                    'days_due_back',
                    'daily_late_fee',
                ],
                'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ])
            ?>
        </div>
    </div>
</div>