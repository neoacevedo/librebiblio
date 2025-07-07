<?php

use common\models\Biblio;
use common\models\Collection;
use common\models\MaterialType;
use kartik\grid\GridView;
use kartik\grid\GridViewInterface;
use yii\bootstrap5\Html;

return [
    [
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'value' => function ($model, $key, $index) {
            return GridViewInterface::ROW_COLLAPSED;
        },
        'detailRowCssClass' => GridViewInterface::TYPE_DEFAULT,
        // uncomment below and comment detail if you need to render via ajax
        // 'detailUrl' => Url::to(['/site/book-details']),
        'detail' => function (common\models\Biblio $model, $key, $index, $column) {
            $biblioCopySearch = new \common\models\BiblioCopySearch();
            $biblioCopySearch->bibid = $model->id;
            $biblioCopy = $biblioCopySearch->search(Yii::$app->request->queryParams);

            return GridView::widget([
                "dataProvider" => $biblioCopy,
                'summary' => '',
                'panel' => [
                    'type' => 'default',
                    'heading' => Yii::t('app', 'Bibliography Copy Information')
                ],
                'toolbar' => false,
                'columns' => [
                    'barcode_nmbr',
                    [
                        'attribute' => 'status_cd',
                        'value' => function ($model) {
                            return common\models\BiblioStatusDm::findOne(['code' => $model->status_cd])->description;
                        },
                        'label' => Yii::t('app', 'Status')
                    ],
                ],
            ]);
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'expandOneOnly' => true,
        'allowBatchToggle' => true,
    ],
    ['class' => yii\grid\SerialColumn::class],
    [
        'attribute' => 'image_file',
        'format' => 'html',
        'value' => function (Biblio $model): string|null {
            if ($model->image_file !== '') {
                return Html::img(src: $model->image_file, options: ['class' => 'img-fluid img-thumbnail', 'style' => 'max-width: 200px;']);
            }
            return null;
        }
    ],
    'title:ntext',
    'author:ntext',
    [
        'attribute' => 'materialType',
        'value' => 'materialType.description',
        'label' => 'Material',
        'filter' => MaterialType::asArray(),
        'filterInputOptions' => [
            'prompt' => '',
            'class' => 'form-control',
            'id' => null,
        ],
    ],
    [
        'attribute' => 'collection',
        'value' => 'collection.description',
        'filter' => Collection::asArray(),
        'filterInputOptions' => [
            'prompt' => '',
            'class' => 'form-control',
            'id' => null,
        ],
        'label' => Yii::t('app', 'Collection')
    ],
    [
        'attribute' => 'user',
        'value' => 'user.username',
        'label' => \Yii::t('app', 'Updated by')
    ],
    [
        'attribute' => 'created_at',
        'format' => ['date', 'php:Y-m-d H:i:s'],
    ],
    ['class' => 'kartik\grid\ActionColumn'],
];