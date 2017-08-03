<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['index']];
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

    <p>
        <?= Html::a(Yii::t('app', 'Add Copy'), ['biblio-copy/create', 'bibid' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>

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
                'label' => \Yii::t('app', 'User')
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
                'label' => Yii::t('app', 'Call Nmbr1')
            ],
            'title:ntext',
            'title_remainder:ntext',
            'responsibility_stmt:ntext',
            'author:ntext',
            [
                'attribute' => 'opac_flg',
                'value' => 1 ? Yii::t('app', 'Yes') : Yii::t('app', 'No'),
            ]
        ],
    ])
    ?>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <h4><?= Yii::t('app', 'Bibliography Copy Information') ?></h4>
        </div>
    </div>
    <?php
    $biblioCopySearch = new \app\models\BiblioCopySearch();
    $biblioCopy = $biblioCopySearch->search(['bibid' => $model->id]);

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
            'status_begin_dt',
            'due_back_dt',
            ['class' => 'yii\grid\ActionColumn'],
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
