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

    <h1><?= Html::encode($this->title) ?>
    </h1>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?=
        SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => Yii::t('app', 'Options'),
            'headingOptions' => ['class' => 'head-style'],
            'items' => [['label' => Yii::t('app', 'Create User'), 'url' => ['admin/users-create'], 'type' => 'link'],
                ['label' => Yii::t('app', 'Roles'), 'url' => ['admin/users/role']],
                ['label' => Yii::t('app', 'Permissions'), 'url' => ['admin/users/permission']],
                ['label' => Yii::t('app', 'Assignment'), 'url' => ['admin/users/assignment']]],
        ]);
        ?>
    </div>
    <div class="box">
        <DIV class="box-body">
            <div class="col-lg-9 col-md-9 col-sm-9">
                <p>
                    <?= Html::a(Yii::t('yii', 'Update'), ['admin/users-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php
                    if ($model->id !== Yii::$app->user->id) {
                        echo Html::a(Yii::t('app', 'Delete'), ['admin/users-delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]);
                    }
                    ?>
                </p>

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
                ])
                ?>
            </div>
        </div>
    </div>
</div>