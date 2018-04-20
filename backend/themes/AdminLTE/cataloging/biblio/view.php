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
    <div class="box">
        <div class="box-body">
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
                        'value' => function($model) {
                            return Html::img(Yii::$app->storage->getUrl("images/covers/{$model->image_file}"), ['alt' => $model->title,
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
                        'value' => function($model) {
                            return ($model->opac_flg == 1) ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
                        },
                    ]
                ],
                'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ])
            ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3><?= Yii::t('app', 'Bibliography Copy Information') ?></h3>
        </div>
        <div class="box-body">
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
                    'status_begin_dt',
                    'due_back_dt',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
                'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ]);
            ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3><?= Yii::t('app', 'Additional Bibliographic Information') ?></h3>
        </div>
        <div class="box-body">
            <?=
            DetailView::widget([
                "model" => $model,
                "attributes" => $usmarc,
                'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ]);
            ?>
        </div>
    </div>
</div>
