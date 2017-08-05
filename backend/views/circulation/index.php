<?php

use yii\helpers\Html;
use pceuropa\menu\Menu;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Circulation');
$this->params['breadcrumbs'][] = $this->title;
$items = [];
foreach (Menu::NavbarLeft(1) as $menu) {
    $item['label'] = Yii::t('app', $menu['label']);
    $item['url'] = $menu['url'];
    $item['type'] = $menu['type'];
    array_push($items, $item);
}
?>
<div class="circulation-index">

    <div class="user-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <?=
            SideNav::widget([
                'type' => SideNav::TYPE_DEFAULT,
                'heading' => Yii::t('app', 'Circulation'),
                'items' => $items,
            ]);
            ?>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9">
            <div class="row">
                
                OpenBiblio2 circulation forms are designed to support efficient circulation when using a barcode scanner and 
                <a href="../shared/help.php?page=barcodes">barcodes</a> 
                printed on member cards and labeled to copies.
                <br>
                It is also possible to circulate when barcode numbers are not known; members can be searched by last 
                name and OPAC-based 
                <a href="../shared/help.php?page=opacLookup">Barcode Lookup</a> 
                retrieves a copy's barcode number for Check Out, Check In or Hold.
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4">
                <h4><?= Yii::t('app', 'Search User') ?></h4>
                <?= $this->render('_search', ['model' => $searchModel]) ?>
            </div>
        </div>

    </div>
</div>