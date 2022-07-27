<?php

use yii\helpers\Html;
use yii\grid\GridView;
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
                ['class' => 'yii\grid\SerialColumn'],
                // 'collection_cd',
                // 'call_nmbr1',
                // 'call_nmbr2',
                // 'call_nmbr3',
                [
                    'attribute' => 'image_file',
                    'value' => function ($model) {
                        return Html::img("/" .$model->image_file, ['alt' => $model->title,
                                    'title' => $model->title,
                                    'class' => 'img-thumbnail',
                                    'style' => 'width: 200px'
                                ]);
                    },
                    'format' => 'raw',
                    'label' => 'Image',
                    'contentOptions' => ['class' => 'w-50 text-center'],
                    'headerOptions' => ['class' => 'w-50'],
                    'enableSorting' => false
                ],
                [
                    'attribute' => 'materialType',
                    'value' => function ($model) {
                        if ($model->icon != "") {
                            return Html::tag("span", "", [
                                    'title' => $model->materialType->description,
                                    'class' => $model->icon
                                ]);
                        } else {
                            if ($model->image_file != "") {
                                return Html::img($model->img_file, [
                                    'title' => $model->materialType->description,
                                    'style' => 'max-width: 25px'
                                ]);
                            }
                        }
                    },
                    'label' => 'Material',
                    'format' => 'html',
                    'contentOptions' => ['class' => 'text-center align-middle', 'style' => 'font-size: 2rem'],
                ],
                [
                    'label' => Yii::t('app', 'Title'),
                    'attribute' => 'title',
                    'value' => function ($model) {
                        return "<h5>$model->title</h5><h6>$model->title_remainder</h6>";
                    },
                    'format' => 'raw'
                ],
                // 'responsibility_stmt:ntext',
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
                [
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions' => ['style' => 'color:#337ab7'],
                    'template' => '{view}{placehold}',
                    'contentOptions' => ['class' => 'text-center align-middle', 'style' => 'font-size: 2rem'],
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="bi bi-eye"></span>&nbsp;', ["biblio/view", "id" => $model->id], [
                                        'title' => Yii::t('app', 'View'),
                                        'class' => 'text-decoration-none'
                            ]);
                        },
                        'placehold' => function ($url, $model) {
                            return Html::a('<span class="bi bi-check"></span>&nbsp;', $url, [
                                        'title' => Yii::t('app', 'Place Hold'),
                                        'class' => 'text-decoration-none'
                            ]);
                        },
                    ],
                    // 'urlCreator' => function ($action, $model, $key, $index) {
                    //     if ($action === 'view') {
                    //         return yii\helpers\Url::to(["biblio/view", "id" => $model->id]);
                    //     }
                    // }
                ],
            ],
        ]);
        ?>
    </div>
    <?php Pjax::end(); ?>
</div>