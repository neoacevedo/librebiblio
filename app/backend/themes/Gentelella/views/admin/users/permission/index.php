<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $searchModel johnitvn\rbacplus\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/rbac', 'Permissions Manager');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Staff'), 'url' => ['admin/users']];
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>
<div class="auth-item-index">
    <h1><?= $this->title ?></h1>
    <?= $this->render('../_sidebar') ?>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <div id="ajaxCrudDatatable">
            <?=
            GridView::widget([
                'id' => 'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax' => true,
                'columns' => require(__DIR__ . '/_columns.php'),
                'toggleDataOptions' => [
                    'all' => [
                        'icon' => 'resize-full',
                        'class' => 'btn btn-default',
                        'label' => Yii::t('app/rbac', 'All'),
                        'title' => Yii::t('app/rbac', 'Show all data')
                    ],
                    'page' => [
                        'icon' => 'resize-small',
                        'class' => 'btn btn-default',
                        'label' => Yii::t('app/rbac', 'Page'),
                        'title' => Yii::t('app/rbac', 'Show first page data')
                    ],
                ],
                'toolbar' => [
                    ['content' =>
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['role' => 'modal-remote', 'title' => Yii::t('app/rbac', 'Create new rule'), 'class' => 'btn btn-default']) .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => Yii::t('app/rbac', 'Reload Grid')]) .
                        '{toggleData}' .
                        '{export}'
                    ],
                ],
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'panel' => [
                    'type' => 'primary',
                    'heading' => '<i class="glyphicon glyphicon-list"></i> ' . $this->title,
                    'before' => '<em>' . Yii::t('app/rbac', '* Resize table columns just like a spreadsheet by dragging the column edges.') . '</em>',
                    'after' => false,
                ]
            ])
            ?>
        </div>
    </div>
</div>
<?php
Modal::begin([
    "id" => "ajaxCrubModal",
    "footer" => "", // always need it for jquery plugin
])
?>
<?php Modal::end(); ?>
