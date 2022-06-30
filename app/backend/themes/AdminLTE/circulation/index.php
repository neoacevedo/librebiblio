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

        <?= $this->render("search", ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]) ?>
        
    </div>
</div>