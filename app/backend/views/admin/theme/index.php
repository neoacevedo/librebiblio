<?php

use common\models\Theme;
use kartik\editable\Editable;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/theme', 'Themes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="theme-index">
    <div class="card">
        <div class="card-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <div class="col-lg-12 col-md-12 col-sm-12">

                <div class="row">
                    <div class="col">
                        <?php #Pjax::begin(); ?>
                        <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'pjax' => true,
                                'condensed' => true,
                                'responsive' => true,
                                'responsiveWrap' => false,
                                'panel' => [
                                    'type' => 'default',
                                ],
                                'toolbar' => [
                                    [
                                        'content' =>
                                            Html::button('<i class="fas fa-plus"></i>', [
                                                'class' => 'btn btn-success',
                                                'title' => Yii::t('app/theme', 'Install'),
                                                'role' => 'modal-remote',
                                                'data-target' => '#modalCreate',
                                                'data-toggle' => 'modal'
                                            ]) . ' ' .
                                            Html::a('<i class="fas fa-redo"></i>', ['admin/theme/refresh'], [
                                                'class' => 'btn btn-outline-secondary',
                                                'title' => Yii::t('yii', 'Update'),
                                                'data-pjax' => 1,
                                            ]),
                                        'options' => ['class' => 'btn-group mr-2 me-2']
                                    ],
                                ],
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    'name',
                                    [
                                        'attribute' => 'frontend',
                                        'label' => Yii::t('app/theme', 'Location'),
                                        'filter' => [1 => 'Frontend', 0 => 'Backend'],
                                        'value' => function ($model) {
                                                                    return ($model->frontend == 1) ? 'Frontend' : 'Backend';
                                                                }
                                    ],
                                    'sourcePath',
                                    [
                                        'class' => '\kartik\grid\EditableColumn',
                                        'refreshGrid' => true,
                                        'attribute' => 'active',
                                        'label' => Yii::t('app', 'Status'),
                                        'filter' => [1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')],
                                        'value' => function ($model) {
                                                                    return $model->active == 1 ? Yii::t('app', 'Active') : Yii::t('app', 'Inactive');
                                                                },
                                        'editableOptions' => function ($model, $key, $index) {
                                                                    return [
                                                                        'preHeader' => '<i class="fas fa-edit"></i> ',
                                                                        'header' => Yii::t('app', 'Status'),
                                                                        'inputType' => Editable::INPUT_LIST_BOX,
                                                                        'data' => [1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')],
                                                                        'options' => ['prompt' => '-- Seleccionar --'],
                                                                        'formOptions' => ['action' => ['/admin/theme/update', 'id' => $key]],
                                                                    ];
                                                                },
                                    ],
                                    'created_at',
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        // 'visibleButtons' => [
                                        //     'delete' => function ($model, $key, $index) {
                                        //         return !preg_match('#^@vendor/#', $model->sourcePath) ? true : false;
                                        //     }
                                        // ],
                                        'template' => '{delete}',
                                    ],
                                ],
                                'options' => ['class' => 'table table-striped table-bordered table-responsive']
                            ]); ?>
                        <?php #Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
Modal::begin([
    'id' => 'modalCreate',
    'title' => Yii::t('app/theme', 'Install')
]);

echo $this->render("create", ['model' => new Theme()]);

Modal::end();
