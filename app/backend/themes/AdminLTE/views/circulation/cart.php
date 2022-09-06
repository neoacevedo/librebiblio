<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioCopySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Cart');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="circulation-index">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <?php Pjax::begin(['id' => 'pjax-checkout', 'enablePushState' => false, 'timeout' => 5000, 'clientOptions' => [
                        'replace' => false]
                    ]); ?>
                    <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'id' => 'checkout',
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
                                    'attribute' => 'updated_at',
                                    'format' => ['date', 'php:Y-m-d H:i:s']
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
                                            $url = "index.php?r=circulation/checkin&copyid=$model->id&bibid=$model->bibid&status=in&id=$model->mbr_id&data-pjax=0";
                                            return $url;
                                        }
                                    }],
                            ],
                            'options' => ['class' => 'box table-responsive']
                        ]); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>