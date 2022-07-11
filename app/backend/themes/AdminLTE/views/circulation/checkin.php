<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use pceuropa\menu\Menu;

/* @var $this yii\web\View */
/** @var common\models\BiblioSearch $searchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Check in');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="circulation-index">
    <div class="card">
        <div class="card-body">
            <?php
                Pjax::begin(['id' => 'pjax-checkout', 'enablePushState' => false, 'timeout' => 5000, 'clientOptions' => [
                        'replace' => false]
                ]);
                ?>
            <?=
                GridView::widget([
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
                        'biblio.title',
                        'biblio.author',
                        [
                            'attribute' => 'biblio.material_cd',
                            'value' => function ($model) {
                                $biblio = \common\models\Biblio::findOne(["id" => $model->bibid]);
                                return \common\models\MaterialType::findOne(['id' => $biblio->material_cd])->description;
                            },
                            'label' => 'Material'
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
                                    return Html::a('<span class="glyphicon glyphicon-check"></span>', $url, [
                                                'title' => Yii::t('app', 'Check in'),
                                    ]);
                                }
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'checkin') {
                                    $url = "index.php?r=circulation/update&copyid=$model->id&bibid=$model->bibid&status=crt&id=$model->mbr_id&data-pjax=0";
                                    return $url;
                                }
                            }],
                    ],
                    'options' => ['class' => 'table table-responsive']
                ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>