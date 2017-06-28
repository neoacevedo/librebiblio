<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'updated_at',
            'updated_userid',
            'material_cd',
            'collection_cd',
            'call_nmbr1',
            'call_nmbr2',
            'call_nmbr3',
            'title:ntext',
            'title_remainder:ntext',
            'responsibility_stmt:ntext',
            'author:ntext',
            'topic1:ntext',
            'topic2:ntext',
            'topic3:ntext',
            'topic4:ntext',
            'topic5:ntext',
            'opac_flg',
        ],
    ]) ?>

</div>
