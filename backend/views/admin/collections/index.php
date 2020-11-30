<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CollectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Collections');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="col-lg-3 col-md-3 col-sm-3">
        <?=
        $this->render("../_sidenav");
        ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <p>
            <?= Html::a(Yii::t('app', 'Create Collection'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'description',
                'days_due_back',
                'daily_late_fee',
                ['class' => 'yii\grid\ActionColumn'],
            ],
            'options' => ['class' => 'table table-striped table-bordered table-responsive']
        ]);
        ?>
    </div>
</div>
