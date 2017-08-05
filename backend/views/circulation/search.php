<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\grid\GridView;
use pceuropa\menu\Menu;
use kartik\sidenav\SideNav;

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
<div class="user-search">
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
            <div class="col-lg-4 col-md-4 col-sm-4">
                <?php Pjax::begin(); ?>   <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'username',
                        'first_name',
                        'last_name',
                        'email:email',
                        'phone',
                        'status',
                        // 'created_at',
                        // 'updated_at',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
