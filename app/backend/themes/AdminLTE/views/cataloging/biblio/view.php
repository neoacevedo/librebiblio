<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use kartik\sidenav\SideNav;
use yii\bootstrap4\Nav;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$usmarc = [
    [
        'attribute' => 'topic1',
        'value' => $model->topic1,
        'label' => \Yii::t('biblio', 'Topic1'),
        'visible' => $model->topic1 != "" ? true : false
    ],
    [
        'attribute' => 'topic2',
        'value' => $model->topic2,
        'label' => \Yii::t('biblio', 'Topic2'),
        'visible' => $model->topic2 != "" ? true : false
    ],
    [
        'attribute' => 'topic3',
        'value' => $model->topic3,
        'label' => \Yii::t('biblio', 'Topic3'),
        'visible' => $model->topic3 != "" ? true : false
    ],
    [
        'attribute' => 'topic4',
        'value' => $model->topic4,
        'label' => \Yii::t('biblio', 'Topic4'),
        'visible' => $model->topic4 != "" ? true : false
    ],
    [
        'attribute' => 'topic5',
        'value' => $model->topic5,
        'label' => \Yii::t('biblio', 'Topic5'),
        'visible' => $model->topic5 != "" ? true : false
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

            return $biblioField->field_data;
        },
        'label' => common\models\UsmarcSubfield::findOne(['tag' => $biblioField->tag, 'subfield_cd' => $biblioField->subfield_cd])->description
    ];
    array_push($usmarc, $field);
}

// emulación de data-confirm en elemento "a"
$js = "\$('#copy_delete a').on('click', function(e) {
        a = confirm('" . Yii::t('yii', 'Are you sure you want to delete this item?') . "');
        return a;
    });";
$this->registerJs($js);
?>
<div class="biblio-view">
    <div class="card">
        <nav class="navbar navbar-expand navbar-white navbar-light">
            <?=
                Nav::widget([
                    'options' => ['class' => 'navbar-nav'],
                    'items' => [
                        ['label' => Yii::t('app', 'Add Copy'), 'url' => ['biblio-copy/create', 'bibid' => $model->id]],
                        ['label' => Yii::t('yii', 'Update'), 'url' => ['update', 'id' => $model->id]],
                        ['label' => Yii::t('yii', 'Delete'), 'url' => ['delete', 'id' => $model->id],
                            'options' => ['id' => 'copy_delete']
                        ],
                        ['label' => Yii::t('cataloging', 'EDIT MARC'), 'active' => 'edit-marc'],
                        ['label' => Yii::t('yii', 'View'), 'url' => ['cataloging/biblio-field/index', 'bibid' => $model->id]],
                        ['label' => Yii::t('app', 'New'), 'url' => ['cataloging/biblio-field/create', 'bibid' => $model->id]],
                    ]
                ]) ?>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><?= Yii::t('app', 'Bibliography Information') ?>
            </h3>
        </div>
        <div class="card-body">
            <div class="col">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'created_at',
                        'updated_at',
                        [
                            'attribute' => 'user',
                            'value' => $model->user->username,
                            'label' => \Yii::t('app', 'Updated by')
                        ],
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
                        [
                            'attribute' => 'image_file',
                            'value' => function ($model) {
                                return Html::img($model->image_file, ['alt' => $model->title,
                                            'title' => $model->title,
                                            'class' => 'image-thumbnail center-block',
                                            'style' => 'width: 140px']);
                            },
                            'format' => 'raw'
                        ],
                        'responsibility_stmt:ntext',
                        'author:ntext',
                        [
                            'attribute' => 'opac_flg',
                            'value' => function ($model) {
                                return ($model->opac_flg == 1) ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
                            },
                        ]
                    ],
                    'options' => ['class' => 'table table-striped table-bordered table-responsive']
                ]) ?>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3><?= Yii::t('app', 'Bibliography Copy Information') ?>
            </h3>
        </div>
        <div class="card-body">
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
            'value' => function ($model) {
                return common\models\BiblioStatusDm::findOne(['code' => $model->status_cd])->description;
            },
            'label' => Yii::t('app', 'Status')
        ],
        'status_begin_dt',
        'due_back_dt',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['biblio-copy/view', 'id' => $model->id, 'bibid' => $model->bibid], [
                                'title' => Yii::t('yii', 'View'),
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['biblio-copy/update', 'id' => $model->id, 'bibid' => $model->bibid], [
                                'title' => Yii::t('yii', 'Update'),
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['biblio-copy/delete', 'id' => $model->id, 'bibid' => $model->bibid], [
                                'title' => Yii::t('app', 'Delete'),
                                'data' => [
                                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'pjax' => 0,
                                ],
                    ]);
                }
            ],
        ],
    ],
    'options' => ['class' => 'table table-striped table-bordered table-responsive']
]); ?>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3><?= Yii::t('app', 'Additional Bibliographic Information') ?>
            </h3>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                "model" => $model,
                "attributes" => $usmarc,
                'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ]) ?>
        </div>
    </div>
</div>