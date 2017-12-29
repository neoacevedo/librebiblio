<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MemberClassifySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Member Classifies');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-classify-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <p>
            <?= Html::a(Yii::t('app', 'Create Member Classify'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="box">
            <div class="box-body">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'description',
                        'max_fines',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
