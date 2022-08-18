<?php

use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="card">
        <div class="card-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]);?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'panel' => [
                    'type'=>'default',
                ],
                'toolbar' => [
                    [
                        'content' =>
                                Html::a(
                                    '<i class="fas fa-plus"></i>',
                                    ['create'],
                                    [
                                        'class' => 'btn btn-success',
                                        'title' => Yii::t('app', 'Create User'),
                                    ]
                                )
                    ],
                ],
                'columns' => [
                    'id',
                    'username',
                    'first_name',
                    'last_name',
                    'address',
                    //'auth_key',
                    //'password_hash',
                    //'password_reset_token',
                    //'email:email',
                    'status',
                    'phone',
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:Y-m-d H:i:s']
                    ],
                    //'updated_at',
                    //'verification_token',
                    [
                        'class' => ActionColumn::class,
                        'template' => '{update} {delete}',
                        'visibleButtons' => [
                            'delete' => function (User $model, $key, $index) {
                                return Yii::$app->user->id !== $model->id;
                            }
                        ],
                        'urlCreator' => function ($action, User $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ]
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>