<?php

use yii\helpers\Html;
use yii\grid\GridView;
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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  
    ?>
    <div class="box">
        <div class="box-body">
            <?php Pjax::begin(); ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => yii\grid\SerialColumn::class],
                        'id',
                        'title:ntext',
                        'created_at',
                        'updated_at',
                        [
                            'attribute' => 'user',
                            'value' => 'user.username',
                            'label' => \Yii::t('app', 'Updated by')
                        ],
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
                            'value' => function ($model) {
                                $biblioCopySearch = new \common\models\BiblioCopySearch();
                                $biblioCopySearch->bibid = $model->id;
                                $biblioCopy = $biblioCopySearch->search(Yii::$app->request->queryParams);

                                return GridView::widget([
                                    "dataProvider" => $biblioCopy,
                                    'summary' => '',
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
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
                            'label' => 'Copias',
                            'format' => 'raw'
                        ],
                        // 'collection_cd',
                        // 'call_nmbr1',
                        // 'call_nmbr2',
                        // 'call_nmbr3',
                        // 'title_remainder:ntext',
                        // 'responsibility_stmt:ntext',
                        // 'author:ntext',
                        // 'topic1:ntext',
                        // 'topic2:ntext',
                        // 'topic3:ntext',
                        // 'topic4:ntext',
                        // 'topic5:ntext',
                        // 'opac_flg',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                    'options' => ['class' => 'table table-responsive']
                ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>