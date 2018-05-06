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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            // 'collection_cd',
            // 'call_nmbr1',
            // 'call_nmbr2',
            // 'call_nmbr3',
            [
                'attribute' => 'image_file',
                'value' => function($model) {
                    return Html::img($model->image_file, ['alt' => $model->title,
                                'title' => $model->title,
                                'class' => 'image-responsive center-block',
                                'style' => 'width: 33.333333%']);
                },
                'format' => 'raw',
                'label' => 'Image'
            ],
            [
                'attribute' => 'materialType',
                'value' => function($model) {
                    return Html::img(Yii::$app->storage->getUrl(Yii::$app->storage->prefix.$model->materialType->image_file), ['alt' => $model->materialType->description,
                                'title' => $model->materialType->description,
                                'class' => 'image-responsive center-block',
                                'style' => 'width: 33.333333%']);
                },
                'label' => 'Material',
                'format' => 'raw'
            ],
            [
                'label' => Yii::t('app', 'Title'),
                'attribute' => 'title',
                'value' => function($model) {
                    return "<h5>$model->title</h5><h6>$model->title_remainder</h6>";
                },
                'format' => 'raw'
            ],
            // 'responsibility_stmt:ntext',
            'author:ntext',
            [
                'label' => Yii::t('app', 'Number of copies'),
                'value' => function($model) {
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
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp;', $url, [
                                    'title' => Yii::t('app', 'View'),
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        return yii\helpers\Url::to(["biblio/view", "id" => $model->id]);
                    }
                }
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?></div>
