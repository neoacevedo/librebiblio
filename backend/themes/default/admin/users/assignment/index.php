<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */
$this->title = Yii::t('rbac', 'User Assignment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Staff'), 'url' => ['admin/users']];
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
?>
<h1><?= $this->title ?></h1>
<div class="col-lg-3 col-md-3 col-sm-3">
    <?php
    if (YII_ENV_DEV) {
        echo SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => Yii::t('app', 'Options'),
            'headingOptions' => ['class' => 'head-style'],
            'items' => [['label' => Yii::t('app', 'Create User'), 'url' => ['admin/users-create'], 'type' => 'link'],
                ['label' => Yii::t('app', 'Roles'), 'url' => ['admin/users/role']],
                ['label' => Yii::t('app', 'Rules'), 'url' => ['admin/users/rule']],
                ['label' => Yii::t('app', 'Permissions'), 'url' => ['admin/users/permission']],
                ['label' => Yii::t('app', 'Assignment'), 'url' => ['admin/users/assignment'], 'options' => ['class' => 'active']]],
        ]);
    } else {
        echo SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => Yii::t('app', 'Options'),
            'headingOptions' => ['class' => 'head-style'],
            'items' => [['label' => Yii::t('app', 'Create User'), 'url' => ['admin/users-create'], 'type' => 'link'],
                ['label' => Yii::t('app', 'Roles'), 'url' => ['admin/users/role']],
                ['label' => Yii::t('app', 'Assignment'), 'url' => ['admin/users/assignment'], 'options' => ['class' => 'active']]],
        ]);
    }
    ?>
</div>
<div class="col-lg-9 col-md-9 col-sm-9">
    <?php
    echo GridView::widget([
        'id' => 'crud-datatable',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require __DIR__ . '/_columns.php',
        'pjax' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'toggleDataOptions' => [
            'all' => [
                'icon' => 'resize-full',
                'class' => 'btn btn-default',
                'label' => Yii::t('rbac', 'All'),
                'title' => Yii::t('rbac', 'Show all data')
            ],
            'page' => [
                'icon' => 'resize-small',
                'class' => 'btn btn-default',
                'label' => Yii::t('rbac', 'Page'),
                'title' => Yii::t('rbac', 'Show first page data')
            ],
        ],
        'toolbar' => [
            ['content' =>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => Yii::t('rbac', 'Reload Grid')]) .
                '{toggleData}'
            ],
        ],
        'panel' => [
            'type' => 'primary',
            'heading' => '<i class="glyphicon glyphicon-list"></i> ' . $this->title,
            'before' => '<em>' . Yii::t('rbac', '* Resize table columns just like a spreadsheet by dragging the column edges.') . '</em>',
            'after' => false,
        ]
    ]);

    Modal::begin([
        "id" => "ajaxCrubModal",
        "footer" => "", // always need it for jquery plugin
    ]);
    Modal::end();
    ?>
</div>



