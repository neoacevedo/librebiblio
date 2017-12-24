<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\grid\GridView;
use pceuropa\menu\Menu;
use kartik\sidenav\SideNav;

$this->title = Yii::t('app', 'Circulation');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-search">
    <div class="user-index">
        <h1><?= Html::encode($this->title) ?></h1>
        
        <div class="col-lg-9 col-md-9 col-sm-9">
            <?php Pjax::begin(); ?>   <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'username',
                    'first_name',
                    'last_name',
                    'email:email',
                    'phone',
                    [
                        'attribute' => 'status',
                        'value' => function($model) {
                            switch ($model->status) {
                                case $model::STATUS_ACTIVE:
                                    return Yii::t('app', 'Active');
                                case $model::STATUS_BLOCKED:
                                    return Yii::t('app', 'Blocked');
                                case $model::STATUS_DELETED:
                                    return Yii::t('app', 'Deleted');
                            }
                        }
                    ],
                    // 'created_at',
                    // 'updated_at',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['style' => 'color:#337ab7'],
                        'template' => '{view}{update}{delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                            'title' => Yii::t('app', 'View'),
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                            'title' => Yii::t('app', 'Update'),
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                            'title' => Yii::t('app', 'Delete'),
                                ]);
                            }
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'view') {
                                $url = 'index.php?r=circulation/member-view&id=' . $model->id;
                                return $url;
                            }

                            if ($action === 'update') {
                                $url = 'index.php?r=circulation/member-update&id=' . $model->id;
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url = 'index.php?r=circulation/member-delete&id=' . $model->id;
                                return $url;
                            }
                        }
                    ],
                ],
                'options' => ['class' => 'box table-responsive']
            ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
