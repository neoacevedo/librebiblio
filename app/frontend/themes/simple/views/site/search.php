<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Biblio Search');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-index">

    <h1><?= Html::encode($this->title) ?>
    </h1>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>
    <div class="table-responsive">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'width' => '50px',
                    'value' => function ($model, $key, $index) {
                        return kartik\grid\GridView::ROW_COLLAPSED;
                    },
                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                    // uncomment below and comment detail if you need to render via ajax
                    // 'detailUrl' => Url::to(['/site/book-details']),
                    'detail' => function (common\models\Biblio $model, $key, $index, $column) {
                        $biblioCopySearch = new \common\models\BiblioCopySearch();
                        $biblioCopySearch->bibid = $model->id;
                        $biblioCopy = $biblioCopySearch->search(Yii::$app->request->queryParams);

                        return GridView::widget([
                            "dataProvider" => $biblioCopy,
                            'summary' => '',
                            'columns' => [
                                'barcode_nmbr',
                                [
                                    'attribute' => 'status_cd',
                                    'value' => function (\common\models\BiblioCopy $model) {
                                        return common\models\BiblioStatusDm::findOne(['code' => $model->status_cd])->description;
                                    },
                                    'label' => Yii::t('app', 'Status')
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['style' => 'color:#337ab7'],
                                    'template' => '{add-to-cart}{placehold}',
                                    'contentOptions' => ['class' => 'text-center align-middle', 'style' => 'font-size: 1.5rem'],
                                    'buttons' => [
                                        'checkout' => function ($url, $model) {
                                            return Html::a('<span class="bi bi-eye"></span>&nbsp;', $url, [
                                                        'title' => Yii::t('yii', 'View'),
                                                        'class' => 'text-decoration-none'
                                            ]);
                                        },
                                        'placehold' => function ($url, $model) {
                                            return Html::a('<span class="bi bi-check"></span>&nbsp;', $url, [
                                                        'title' => Yii::t('app', 'Place Hold'),
                                                        'class' => 'text-decoration-none'
                                            ]);
                                        },
                                        'urlCreator' => function ($action, $model, $key, $index) {
                                            if ($action == "add-to-cart") {
                                                return yii\helpers\Url::to([
                                                    "circulation/$action",
                                                    "copyid" => $model->id,
                                                    'bibid' => $model->bibid,
                                                    'status' => 'crt'
                                                ]);
                                            }

                                            if ($action == "placehold") {
                                                return yii\helpers\Url::to([
                                                    "circulation/$action",
                                                    "copyid" => $model->id,
                                                    'bibid' => $model->bibid
                                                ]);
                                            }
                                        }
                                    ],
                                ],
                            ],
                        ]);
                    },
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'expandOneOnly' => true,
                    'allowBatchToggle' => true,
                    'expandIcon' => '<i class="bi bi-arrows-expand"></i>',
                    'collapseIcon' => '<i class="bi bi-arrows-collapse"></i>',
                ],
                ['class' => 'yii\grid\SerialColumn'],
                // 'collection_cd',
                // 'call_nmbr1',
                // 'call_nmbr2',
                // 'call_nmbr3',
                [
                    'attribute' => 'image_file',
                    'value' => function (\common\models\Biblio $model) {
                        if ($model->image_file !== "") {
                            return Html::img("/" .$model->image_file, ['alt' => $model->title,
                                        'title' => $model->title,
                                        'class' => 'img-thumbnail',
                                        'style' => 'width: 200px'
                                    ]);
                        }
                    },
                    'format' => 'raw',
                    'label' => 'Image',
                    'contentOptions' => ['class' => 'w-50 text-center'],
                    'headerOptions' => ['class' => 'w-50'],
                    'enableSorting' => false
                ],
                [
                    'attribute' => 'materialType',
                    'value' => function (\common\models\Biblio $model) {
                        if ($model->materialType->icon !== null) {
                            return Html::tag("span", "", [
                                'title' => $model->materialType->description,
                                'class' => $model->materialType->icon
                            ]);
                        } elseif ($model->materialType->image_file !== null) {
                            return Html::img($model->materialType->image_file, [
                                'title' => $model->materialType->description,
                                'style' => 'max-width: 25px'
                            ]);
                        }
                    },
                    'label' => 'Material',
                    'format' => 'html',
                    'contentOptions' => ['class' => 'text-center align-middle', 'style' => 'font-size: 2rem'],
                ],
                'title:ntext',
                'author:ntext',
                [
                    'label' => Yii::t('app', 'Number of copies'),
                    'value' => function ($model) {
                        $biblioCopySearch = new \common\models\BiblioCopySearch();
                        $biblioCopySearch->bibid = $model->id;
                        $biblioCopy = $biblioCopySearch->search(Yii::$app->request->queryParams);

                        return $biblioCopy->count;
                    }
                ],
                // 'topic1:ntext',
                // 'topic2:ntext',
                // 'topic3:ntext',
                // 'topic4:ntext',
                // 'topic5:ntext',
                // 'opac_flg',
            ],
        ]);
?>
    </div>
    <?php Pjax::end(); ?>
</div>