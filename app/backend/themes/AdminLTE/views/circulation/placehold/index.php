<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioHoldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Yii::debug($searchModel);
?>
<div class="biblio-index">
    <?= Html::button(Yii::t('app', 'Place Hold'), ['value' => yii\helpers\Url::to(['circulation/copy-search', 'id' => $id, 'status' => 'hld']),
        'title' => Yii::t('app', 'Place Hold'), 'class' => 'showModalButton btn btn-primary col-lg-12 col-md-12 col-sm-12']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'barcode_nmbr',
                'value' => 'biblioCopy.barcode_nmbr',
                'label' => Yii::t('biblio', 'Barcode Nmbr'),
            ],
            [
                'attribute' => 'title',
                'value' => 'biblio.title',
                'label' => Yii::t('app', 'Title'),
            ],
            [
                'label' => Yii::t('app', 'Author'),
                'attribute' => 'author',
                'value' => 'biblio.author'
            ],
            [
                'attribute' => 'material',
                'value' => 'biblio.materialType.description',
                'label' => Yii::t('app', 'Material Cd')
            ],
            [
                'attribute' => 'due_back_dt',
                'label' => Yii::t('app', 'Due Back Dt'),
                'value' => 'biblioCopy.due_back_dt'
            ],
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view',
                    'delete'
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action == "view") {
                        $url = "index.php?r=cataloging/biblio/view&id=$model->bibid";
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url = "index.php?r=circulation/hold-delete&id=$model->id&mbr_id=$model->mbr_id";
                        return $url;
                    }
                },
                'template' => '{view}&nbsp;{delete}'],
        ],
    ]); ?>
</div>