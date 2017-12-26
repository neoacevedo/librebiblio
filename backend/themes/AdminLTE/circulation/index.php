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

        <div class="col-lg-9 col-md-9 col-sm-9">
            <div class="col-lg-10 col-md-10 col-sm-10">
                <h4><?= Yii::t('app', 'Search User') ?></h4>
                <?= $this->render('_search', ['model' => $searchModel]) ?>
            </div>
        </div>

    </div>
</div>