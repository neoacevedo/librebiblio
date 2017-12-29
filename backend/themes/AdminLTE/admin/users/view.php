<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Staff'), 'url' => ['admin/users']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_sidebar') ?>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['admin/users-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php
            if (Yii::$app->user->id !== $model->id) {
                echo Html::a(Yii::t('app', 'Delete'), ['admin/users-delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]);
            }
            ?>
        </p>
        <div class="box">
            <div class="box-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'username',
                        'first_name',
                        'last_name',
                        'address',
                        'email:email',
                        'phone',
                        [
                            'attribute' => 'status',
                            'value' => $model::STATUS_ACTIVE ? 'Activo' : 'Bloqueado'
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => function($model) {
                                return Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d H:i:s');
                            }
                        ],
                        [
                            'attribute' => 'updated_at',
                            'value' => function($model) {
                                return Yii::$app->formatter->asDate($model->updated_at, 'php:Y-m-d H:i:s');
                            }
                        ],
                    ],
                    'options' => ['class' => 'table table-striped table-bordered table-responsive']
                ])
                ?>
            </div>
        </div>
    </div>
</div>
