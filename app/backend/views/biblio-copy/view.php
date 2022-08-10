<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BiblioCopy */

$this->title = $model->barcode_nmbr;
$this->params['breadcrumbs'][] = ['label' => Yii::t('biblio', 'Biblio Copies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-copy-view">

    <h1><?= Html::encode($this->title) ?>
    </h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id, 'bibid' => $model->bibid], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id, 'bibid' => $model->bibid], [
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
            'bibid',
            'created_at',
            'updated_at',
            'copy_desc',
            'barcode_nmbr',
            'status_cd',
            'status_begin_dt',
            'due_back_dt',
            'mbr_id',
            'renewal_count',
        ],
        'options' => ['class' => 'table table-striped table-bordered table-responsive']
    ])
?>
        </div>
    </div>
</div>