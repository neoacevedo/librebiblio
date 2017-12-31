<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use pceuropa\menu\Menu;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Check in');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="circulation-index">
    <div class="bibliosearch-index">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <?=
            $this->render('_sidenav');
            ?>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9">
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
                        'value' => function($model) {
                            $biblio = \common\models\Biblio::findOne(["id" => $model->bibid]);
                            return \backend\models\MaterialType::findOne(['id' => $biblio->material_cd])->description;
                        },
                        'label' => 'Material'
                    ],
                    'due_back_dt',
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
                                $url = "index.php?r=circulation/create&copyid=$model->id&bibid=$model->bibid&status=crt&id=$model->mbr_id&data-pjax=0";
                                return $url;
                            }
                        }],
                ],
                'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ]);
            ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
