<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$mbr_id = Yii::$app->request->get('id');
?>
<div class="bibliosearch-index">
    <?php
    Pjax::begin(['id' => 'pjax-checkout', 'enablePushState' => false, 'timeout' => 5000, 'clientOptions' => [
        'replace' => false
    ]]);
    ?>
    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'id' => 'checkout',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'barcode_nmbr',
                [
                    'attribute' => 'biblio',
                    'value' => 'biblio.title',
                    'label' => Yii::t('app', 'Title'),
                ],
                [
                    'label' => Yii::t('app', 'Author'),
                    'value' => 'biblio.author'
                ],
                [
                    'attribute' => 'material_cd',
                    'value' => function ($model) {
                        $biblio = \common\models\Biblio::findOne(["id" => $model->bibid]);
                        return \backend\models\MaterialType::findOne(['id' => $biblio->material_cd])->description;
                    },
                    'label' => 'Material'
                ],
                'due_back_dt',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{checkout}',
                    'buttons' => [
                        'checkout' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-plus"></span>', [
                                'circulation/checkout',
                                'id' => Yii::$app->request->get('id'),
                                'copyid' => $model->id,
                                'bibid' => $model->bibid,
                                'status' => 'out',
                                'data-pjax' => 0
                            ], [
                                'title' => Yii::t('app', 'Check Out'),
                            ]);
                        }
                    ],
                    /*'urlCreator' => function ($action, $model, $key, $index) use($mbr_id) {
                    if ($action === 'checkout') {
                        $url = "index.php?r=circulation/checkout&id=$mbr_id&copyid=$model->id&bibid=$model->bibid&status=out&data-pjax=0";
                        return $url;
                    }
                }],*/
                ]
            ],
        ]);
    ?>

    <?php Pjax::end(); ?>
</div>
