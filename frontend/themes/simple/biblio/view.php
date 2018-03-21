<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblio Search'), 'url' => ['site/search']];
$this->params['breadcrumbs'][] = $this->title;

$usmarc = [
    [
        'attribute' => 'topic1',
        'value' => $model->topic1,
        'label' => \Yii::t('app', 'Topic1')
    ],
    [
        'attribute' => 'topic2',
        'value' => $model->topic2,
        'label' => \Yii::t('app', 'Topic2')
    ],
    [
        'attribute' => 'topic3',
        'value' => $model->topic3,
        'label' => \Yii::t('app', 'Topic3')
    ],
    [
        'attribute' => 'topic4',
        'value' => $model->topic4,
        'label' => \Yii::t('app', 'Topic4')
    ],
    [
        'attribute' => 'topic5',
        'value' => $model->topic5,
        'label' => \Yii::t('app', 'Topic5')
    ]
];
foreach ($model->biblioFields as $biblioField) {
    $field = [
        'attribute' => 'biblioFields',
        'value' => $biblioField->field_data,
        'label' => backend\models\UsmarcSubfield::findOne(['tag' => $biblioField->tag, 'subfield_cd' => $biblioField->subfield_cd])->description
    ];
    array_push($usmarc, $field);
}
?>
<div class="biblio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'updated_at',
            [
                'attribute' => 'materialType',
                'value' => $model->materialType->description,
                'label' => 'Material'
            ],
            [
                'attribute' => 'collection',
                'value' => $model->collection->description,
                'label' => Yii::t('app', 'Collection')
            ],
            [
                'attribute' => 'call_nmbr1',
                'value' => "$model->call_nmbr1 $model->call_nmbr2 $model->call_nmbr3",
                'label' => Yii::t('app', 'Call Nmbr1')
            ],
            'title:ntext',
            'title_remainder:ntext',
            'responsibility_stmt:ntext',
            'author:ntext',
        ],
    ])
    ?>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <h4><?= Yii::t('app', 'Bibliography Copy Information') ?></h4>
        </div>
    </div>
    <?php
    $biblioCopySearch = new \common\models\BiblioCopySearch();
    $biblioCopy = $biblioCopySearch->search(['BiblioCopySearch' => ['bibid' => $model->id]]);

    echo GridView::widget([
        "dataProvider" => $biblioCopy,
        'summary' => '',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'barcode_nmbr',
            'copy_desc',
            [
                'attribute' => 'status_cd',
                'value' => function($model) {
                    return common\models\BiblioStatusDm::findOne(['code' => $model->status_cd])->description;
                },
                'label' => Yii::t('app', 'Status')
            ],
//            'status_begin_dt',
//            'due_back_dt',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{placehold}&nbsp;&nbsp;{checkout}',
                'buttons' => [
                    'placehold' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, [
                                    'title' => Yii::t('app', 'Place Hold'),
                        ]);
                    },
                    'checkout' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-ok-sign"></span>', $url, [
                                    'title' => Yii::t('app', 'Check out'),
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    return \yii\helpers\Url::to(["circulation/$action", "id" => Yii::$app->user->id, "copyid" => $model->id, "bibid" => $model->bibid]);
                    /*if ($action === 'placehold') {
                        return \yii\helpers\Url::to(["circulation/placehold", "id" => Yii::$app->user->id, "copyid" => $model->id, "bibid" => $model->bibid]);
                    }*/ 
                }],
        ],
    ]);
    ?>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <h4><?= Yii::t('app', 'Additional Bibliographic Information') ?></h4>
        </div>
    </div>
    <?=
    DetailView::widget([
        "model" => $model,
        "attributes" => $usmarc
    ]);
    ?>
</div>
