<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use Mpdf\Writer\JavaScriptWriter;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Nav;
use yii\widgets\Pjax;

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
$js = <<<JAVASCRIPT
    document.getElementById("btnModal").addEventListener('click', function(e) {
        e.preventDefault();
        fetch(this.getAttribute('href'), {
            method: 'GET',
        }).then(response => response.text())
        .then(text => {
            document.getElementById("modalContent").innerHTML = text;
            $("#modal").modal('show');
        });
    });

    var btnUpdates = document.getElementsByClassName("btnUpdate");
    
    Array.from(btnUpdates).forEach(element => element.addEventListener('click', function(e) {
        e.preventDefault();
        fetch(this.getAttribute('href'), {
            method: 'GET',
        }).then(response => response.text())
        .then(text => {
            document.getElementById("modalContentUpdate").innerHTML = text;
            $("#modalUpdate").modal('show');
        });
    }));
JAVASCRIPT;

$this->registerJs($js, yii\web\View::POS_END);
?>
<div class="biblio-view">
    <div class="card">
        <nav class="navbar navbar-expand navbar-white navbar-light">
            <?= Nav::widget([
                    'options' => ['class' => 'navbar-nav'],
                    'items' => [
                        ['label' => Yii::t('yii', 'Update'), 'url' => ['update', 'id' => $model->id]],
                        ['label' => Yii::t('app', 'Create from This'), 'url' => ['create-from-this', 'id' => $model->id]],
                        ['label' => Yii::t('yii', 'Delete'), 'url' => ['delete', 'id' => $model->id]],
                        ['label' => Yii::t('cataloging', 'EDIT MARC'), 'active' => 'edit-marc'],
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
                        [
                            'attribute' => 'created_at',
                            'format' => ['date', 'php:Y-m-d H:i:s']
                        ],
                        [
                            'attribute' => 'updated_at',
                            'format' => ['date', 'php:Y-m-d H:i:s']
                        ],
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
                                if ($model->image_file !== "") {
                                    return Html::img($model->image_file, ['alt' => $model->title,
                                                'title' => $model->title,
                                                'class' => 'image-thumbnail center-block',
                                                'style' => 'width: 100px']);
                                }
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
Pjax::begin();
echo GridView::widget([
    "dataProvider" => $biblioCopy,
    'panel' => [
        'type'=>'default',
    ],
    'toolbar'=> [
        'content' => Html::a(
            '<i class="fas fa-plus"></i>',
            ['biblio-copy/create', 'bibid' => $model->id, 'data-pjax' => 1],
            [
                'id' => 'btnModal',
                'title' => Yii::t('app', 'Add Copy'),
                'class' => 'btn btn-success',
                'data-pjax' => 1,
                'data-toggle' => 'modal',
                'data-target' => '#modal',
            ]
        )
    ],
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
            'template' => '{update}&nbsp;&nbsp;{delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="fas fa-pen"></span>', ['biblio-copy/update', 'id' => $model->id, 'bibid' => $model->bibid], [
                                'title' => Yii::t('yii', 'Update'),
                                'class' => 'btnUpdate'
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="fas fa-trash"></span>', ['biblio-copy/delete', 'id' => $model->id, 'bibid' => $model->bibid], [
                                'title' => Yii::t('app', 'Delete'),
                                'data' => [
                                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'pjax' => 1,
                                ],
                    ]);
                }
            ],
        ],
    ],
    'options' => ['class' => 'table table-striped table-bordered table-responsive']
]);
Pjax::end();
?>
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
<?php
Modal::begin([
    'id' => 'modal',
    'title' => Yii::t('app', 'Add Copy')
]);
?>
<div id="modalContent"></div>
<?php
Modal::end();

Modal::begin([
    'id' => 'modalUpdate',
    'title' => Yii::t('yii', 'Update')
]);
?>
<div id="modalContentUpdate"></div>
<?php
Modal::end();
