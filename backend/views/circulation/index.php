<?php

use yii\helpers\Html;
use pceuropa\menu\Menu;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Circulation');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="circulation-index">

    <div class="user-index">

        <h2><?= Html::encode($this->title) ?></h2>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h4><?= Yii::t('app', 'Search User') ?></h4>
                </div>
                <div class="box-body">
                    <?= $this->render('_search', ['model' => $searchModel]) ?>
                </div>
            </div>
        </div>
    </div>