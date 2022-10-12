<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioCoptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$mbr_id = Yii::$app->request->get('id');
$status = Yii::$app->request->get('status');
?>
<div class="bibliosearch-index">
    <?php
    Pjax::begin(['id' => 'pjax-checkout', 'enablePushState' => false, 'timeout' => 5000, 'clientOptions' => [
            'replace' => false]
    ]); ?>
    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'id' => 'checkout',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'barcode_nmbr',
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
            'attribute' => 'status_cd',
            'value' => function ($model) {
                return common\models\BiblioStatusDm::findOne(['code' => $model->status_cd])->description;
            },
        ],
        'due_back_dt',
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{checkout}',
            'buttons' => [
                'checkout' => function ($url, $model) use ($status) {
                    $text = ($status == 'out') ? Yii::t('app', 'Check Out') : Yii::t('app', 'Place Hold');
                    return Html::a('<span class="fas fa-plus"></span>', $url, [
                                'title' => Yii::t('app', $text),
                    ]);
                }
            ],
            'urlCreator' => function ($action, $model, $key, $index) use ($mbr_id, $status) {
                if ($action === 'checkout') {
                    $url = "index.php?r=circulation/create&id=$mbr_id&copyid=$model->id&bibid=$model->bibid&status=$status&data-pjax=0";
                    return $url;
                }
            }],
    ],
    'options' => ['class' => 'box table-responsive']
]); ?>

    <?php Pjax::end(); ?>
</div>