<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
    <div class="col-lg-9 col-md-9 col-sm-9">
        <?php Pjax::begin(); ?>    <?=
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
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>
