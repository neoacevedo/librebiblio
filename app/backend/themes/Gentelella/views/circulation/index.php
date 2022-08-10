<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Staff');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Staff'), 'url' => ['admin/users']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?>
    </h1>

    <?= $this->render('_sidebar') ?>

    <div class="col-lg-9 col-md-9 col-sm-9">
        <?php Pjax::begin(); ?> <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'username',
                'first_name',
                'last_name',
                'address',
                // 'auth_key',
                // 'password_hash',
                // 'password_reset_token',
                // 'email:email',
                // 'phone',
                // 'status',
                // 'created_at',
                // 'updated_at',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions' => ['style' => 'color:#337ab7'],
                    'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp;', $url, [
                                        'title' => Yii::t('yii', 'View'),
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp;', $url, [
                                        'title' => Yii::t('yii', 'Update'),
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            if ($model->id !== Yii::$app->user->id) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>&nbsp;', $url, [
                                            'title' => Yii::t('app', 'Delete'),
                                ]);
                            }
                        }
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = 'index.php?r=admin/users-view&id=' . $model->id;
                            return $url;
                        }

                        if ($action === 'update') {
                            $url = 'index.php?r=admin/users-update&id=' . $model->id;
                            return $url;
                        }
                        if ($action === 'delete') {
                            $url = 'index.php?r=admin/users-delete&id=' . $model->id;
                            return $url;
                        }
                    }
                ],
            ],
            'options' => ['class' => 'table table-striped table-bordered table-responsive']
        ]);
?>
        <?php Pjax::end(); ?>
    </div>
</div>