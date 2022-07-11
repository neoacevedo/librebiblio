<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use pceuropa\menu\Menu;
use kartik\sidenav\SideNav;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Circulation');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="circulation-index">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <a href="<?= \yii\helpers\Url::to(["member/print"]) ?>"
                        target="_blank" class="btn btn-block btn-primary"><?= Yii::t('circulation', 'Print List') ?></a>
                    <?php Pjax::begin(); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'id',
                            'pin',
                            'username',
                            'first_name',
                            'last_name',
                            'email:email',
                            'phone',
                            [
                                'attribute' => 'status',
                                'value' => function ($model) {
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
                                'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['member/view', 'id' => $model->id], [
                                                    'title' => Yii::t('app', 'View'),
                                        ]);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['member/update', 'id' => $model->id], [
                                                    'title' => Yii::t('app', 'Update'),
                                        ]);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['member/delete', 'id' => $model->id], [
                                                    'title' => Yii::t('app', 'Delete'),
                                                    'data' => [
                                                        'confirm' => Yii::t('circulation', 'Are you absolutely sure? You will lose all the information about this user with this action.'),
                                                        'pjax' => 0,
                                                    ],
                                        ]);
                                    }
                                ],
                            ]
                        ],
                        'options' => ['class' => 'table table-responsive']
                    ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>