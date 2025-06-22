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
        'label' => \Yii::t('biblio', 'Topic1')
    ],
    [
        'attribute' => 'topic2',
        'value' => $model->topic2,
        'label' => \Yii::t('biblio', 'Topic2')
    ],
    [
        'attribute' => 'topic3',
        'value' => $model->topic3,
        'label' => \Yii::t('biblio', 'Topic3')
    ],
    [
        'attribute' => 'topic4',
        'value' => $model->topic4,
        'label' => \Yii::t('biblio', 'Topic4')
    ],
    [
        'attribute' => 'topic5',
        'value' => $model->topic5,
        'label' => \Yii::t('biblio', 'Topic5')
    ]
];
foreach ($model->biblioFields as $biblioField) {
    $field = [
        'attribute' => 'biblioFields',
        'format' => 'raw',
        'value' => function () use ($biblioField) {
            if ($biblioField->subfield_cd === 'u') {
                return Html::a($biblioField->field_data, $biblioField->field_data, ['target' => '_blank']);
            }
        },
        'label' => common\models\UsmarcSubfield::findOne(['tag' => $biblioField->tag, 'subfield_cd' => $biblioField->subfield_cd])->description
    ];
    array_push($usmarc, $field);
}
?>
<div class="biblio-view">

    <h1><?= Html::encode($this->title) ?>
    </h1>
    <div class="row">
        <div class="col">
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
                        'label' => Yii::t('biblio', 'Call Nmbr1')
                    ],
                    'title:ntext',
                    'title_remainder:ntext',
                    'responsibility_stmt:ntext',
                    'author:ntext',
                ],
            ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h4><?= Yii::t('app', 'Bibliography Copy Information') ?>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php
                $biblioCopySearch = new \common\models\BiblioCopySearch();
                $biblioCopy = $biblioCopySearch->search(['BiblioCopySearch' => ['bibid' => $model->id]]);
            ?>
            <div class="table-responsive">

                <?= GridView::widget([
                    "dataProvider" => $biblioCopy,
                    'summary' => '',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'barcode_nmbr',
                        'copy_desc',
                        [
                            'attribute' => 'status_cd',
                            'value' => function ($model) {
                                return common\models\BiblioStatusDm::findOne(['code' => $model->status_cd])->description;
                            },
                            'label' => Yii::t('app', 'Status')
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{placehold}{checkout}',
                            'contentOptions' => ['class' => 'text-center align-middle', 'style' => 'font-size: 1.5rem'],
                            'buttons' => [
                                'placehold' => function ($url, $model) {
                                    return Html::a('<span class="bi bi-plus"></span>', $url, [
                                                'title' => Yii::t('app', 'Place Hold'),
                                                'class' => 'text-decoration-none'
                                    ]);
                                },
                                'checkout' => function ($url, $model) {
                                    return Html::a('<span class="bi bi-check"></span>', $url, [
                                                'title' => Yii::t('app', 'Check out'),
                                                'class' => 'text-decoration-none checkout'
                                    ]);
                                }
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'placehold') {
                                    return \yii\helpers\Url::to(["circulation/$action", "copyid" => $model->id, "bibid" => $model->bibid]);
                                } elseif ($action === "checkout") {
                                    return \yii\helpers\Url::to(["circulation/add-to-cart", "copyid" => $model->id, "bibid" => $model->bibid, 'status' => 'out']);
                                }
                            }],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h4><?= Yii::t('app', 'Additional Bibliographic Information') ?>
            </h4>
        </div>
    </div>
    <?=
    DetailView::widget([
        "model" => $model,
        "attributes" => $usmarc
    ]);
    ?>
</div>