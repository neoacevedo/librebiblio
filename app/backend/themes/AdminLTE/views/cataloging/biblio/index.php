<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Collection;
use common\models\MaterialType;

/* @var $this yii\web\View */

/** @var common\models\BiblioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Biblios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]);
    ?>
    <div class="card">
        <div class="card-body">
            <?php Pjax::begin(); ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'panel' => [
                        'type'=>'default',
                    ],
                    'toolbar'=> false,
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
                                    'panel' => [
                                        'type'=>'default',
                                        'heading' => Yii::t('app', 'Bibliography Copy Information')
                                    ],
                                    'toolbar'=> false,
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
                        'title:ntext',
                        'author:ntext',
                        [
                            'attribute' => 'materialType',
                            'value' => 'materialType.description',
                            'label' => 'Material',
                            'filter' => MaterialType::asArray(),
                            'filterInputOptions' => [
                                'prompt' => '', 'class' => 'form-control',
                                'id' => null,
                            ],
                        ],
                        [
                            'attribute' => 'collection',
                            'value' => 'collection.description',
                            'filter' => Collection::asArray(),
                            'filterInputOptions' => [
                                'prompt' => '', 'class' => 'form-control',
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
                            // 'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        ['class' => 'kartik\grid\ActionColumn'],
                    ],
                    'options' => ['class' => 'table-responsive']
                ]);
?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>