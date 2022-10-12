<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use pceuropa\menu\Menu;

/* @var $this yii\web\View */
/** @var common\models\BiblioCopySearch $searchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Check in');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="circulation-index">
    <div class="card">
        <div class="card-body">
            <?php Pjax::begin(['id' => 'pjax-checkout', 'enablePushState' => false, 'timeout' => 5000, 'clientOptions' => [
                        'replace' => false]
            ]); ?>
            <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'id' => 'checkout',
                    'containerOptions' => ['class' => 'card border-primary'],
                    'headerRowOptions' => ['class' => 'kv-table-header', 'color' => 'white'],
                    'filterRowOptions' => ['class' => 'kv-table-header'],
                    'bordered' => true,
                    'striped' => true,
                    'responsive' => true,
                    'responsiveWrap' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'barcode_nmbr',
                        [
                            'attribute' => 'title',
                            'value' => 'biblio.title',
                            'label' => Yii::t('app', 'Title'),
                        ],
                        [
                            'attribute' => 'author',
                            'label' => Yii::t('app', 'Author'),
                            'value' => 'biblio.author'
                        ],
                        [
                            'attribute' => 'material',
                            'value' => 'biblio.materialType.description',
                        ],
                        [
                            'attribute' => 'due_back_dt',
                            'filterType' => GridView::FILTER_DATE,
                            'format' => ['date', 'php:Y-m-d']
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{checkin}',
                            'buttons' => [
                                'checkin' => function ($url, $model) {
                                    return Html::a('<span class="fas fa-check"></span>', $url, [
                                                'title' => Yii::t('app', 'Check in'),
                                    ]);
                                }
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'checkin') {
                                    $url = "index.php?r=circulation/update&copyid=$model->id&bibid=$model->bibid&status=crt&id=$model->mbr_id&data-pjax=1";
                                    return $url;
                                }
                            }],
                    ],
                    'options' => ['class' => 'table table-responsive']
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>