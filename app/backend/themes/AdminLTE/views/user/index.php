<?php

use backend\models\User;
use kartik\editable\Editable;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Staff');
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
                    [
                        'class'=>'\kartik\grid\EditableColumn',
                        'attribute' => 'username',
                        'refreshGrid' => true,
                        'editableOptions' => function ($model, $key, $index) {
                            return [
                                'header'=>'Nombre',
                                'inputType' => Editable::INPUT_TEXT,
                                'formOptions' => ['action' => ['/user/update?id=' . $key]],
                            ];
                        },
                        //'hAlign'=>'right',
                        'vAlign'=>'middle',
                        'width'=>'100px',
                        'pageSummary' => true,
                    ],
                    [
                        'class'=>'\kartik\grid\EditableColumn',
                        'attribute' => 'first_name',
                        'refreshGrid' => true,
                        'editableOptions' => function ($model, $key, $index) {
                            return [
                                'header'=>'Nombre',
                                'inputType' => Editable::INPUT_TEXT,
                                'formOptions' => ['action' => ['/user/update?id=' . $key]],
                            ];
                        },
                        //'hAlign'=>'right',
                        'vAlign'=>'middle',
                        'width'=>'100px',
                        'pageSummary' => true,
                    ],
                    [
                        'class'=>'\kartik\grid\EditableColumn',
                        'attribute' => 'last_name',
                        'refreshGrid' => true,
                        'editableOptions' => function ($model, $key, $index) {
                            return [
                                'header'=>'Nombre',
                                'inputType' => Editable::INPUT_TEXT,
                                'formOptions' => ['action' => ['/user/update?id=' . $key]],
                            ];
                        },
                        //'hAlign'=>'right',
                        'vAlign'=>'middle',
                        'width'=>'100px',
                        'pageSummary' => true,
                    ],
                    [
                        'class'=>'\kartik\grid\EditableColumn',
                        'attribute' => 'address',
                        'refreshGrid' => true,
                        'editableOptions' => function ($model, $key, $index) {
                            return [
                                'header'=>'Nombre',
                                'inputType' => Editable::INPUT_TEXT,
                                'formOptions' => ['action' => ['/user/update?id=' . $key]],
                            ];
                        },
                        //'hAlign'=>'right',
                        'vAlign'=>'middle',
                        'width'=>'100px',
                        'pageSummary' => true,
                    ],
                    [
                        'class'=>'\kartik\grid\EditableColumn',
                        'attribute' => 'email',
                        'refreshGrid' => true,
                        'editableOptions' => function ($model, $key, $index) {
                            return [
                                'header'=>'Nombre',
                                'inputType' => Editable::INPUT_HTML5,
                                'formOptions' => ['action' => ['/user/update?id=' . $key]],
                                'options' => ['type' => 'email']
                            ];
                        },
                        //'hAlign'=>'right',
                        'vAlign'=>'middle',
                        'width'=>'100px',
                        'pageSummary' => true,
                    ],
                    [
                        'class'=>'\kartik\grid\EditableColumn',
                        'attribute' => 'phone',
                        'refreshGrid' => true,
                        'editableOptions' => function ($model, $key, $index) {
                            return [
                                'header'=>'Nombre',
                                'inputType' => Editable::INPUT_TEXT,
                                'formOptions' => ['action' => ['/user/update?id=' . $key]],
                            ];
                        },
                        //'hAlign'=>'right',
                        'vAlign'=>'middle',
                        'width'=>'100px',
                        'pageSummary' => true,
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:Y-m-d H:i:s']
                    ],
                    [
                        'class' => '\kartik\grid\EditableColumn',
                        'attribute' => 'status',
                        'filter' => User::getStatus(),
                        'filterInputOptions' => ['class' => 'form-control', 'id' => null, 'prompt' => '--'],
                        'refreshGrid' => true,
                        'readonly' => function ($model, $key, $index, $widget) {
                            return (Yii::$app->user->id === $model->id);
                        },
                        'value' => function ($model) {
                            $status = "";
                            switch ($model->status) {
                                case 0:
                                    $status = Yii::t("app", 'Blocked');
                                    break;
                                case 1:
                                    $status = Yii::t("app", "Active");
                                    break;
                            }

                            return $status;
                        },
                        'editableOptions' => function ($model, $key, $index) {
                            return [
                                'header'=>'Status',
                                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                                'data' => User::getStatus(),
                                'options' => ['prompt' => '--'],
                                'formOptions' => ['action' => ['/user/update?id=' . $key]],
                            ];
                        },
                        'vAlign'=>'middle',
                        'width'=>'100px',
                        'pageSummary' => true,
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{delete}',
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