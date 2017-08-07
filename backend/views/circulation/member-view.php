<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use pceuropa\menu\Menu;
use kartik\sidenav\SideNav;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$items = [];
foreach (Menu::NavbarLeft(1) as $menu) {
    $item['label'] = Yii::t('app', $menu['label']);
    $item['url'] = $menu['url'];
    $item['type'] = $menu['type'];
    array_push($items, $item);
}
$item['label'] = $model->username;
$item['type'] = "header";

$materialType = backend\models\MaterialType::find()->all();
$collection = \backend\models\Collection::find()->all();
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?=
        SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => Yii::t('app', 'Circulation'),
            'items' => $items,
        ]);
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= $model->username ?></h3>
            </div>
            <div class="table">
                <ul class="nav nav-pills nav-stacked kv-sidenav">
                    <li><a href="/openbiblio2/backend/web/index.php?r=circulation%2Fmember-update&amp;id=<?= $model->id ?>">Actualizar</a></li>
                    <li><a href="/openbiblio2/backend/web/index.php?r=circulation%2Fmember-delete&amp;id=<?= $model->id ?>" data-confirm="<?= Yii::t('app', 'Are you sure you want to delete this item?') ?>" data-method="post">Borrar</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-4 col-sm-4">
        <div class="row">&nbsp;</div>
        <div class="row">&nbsp;</div>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                'first_name',
                'last_name',
                [
                    'attribute' => 'classification',
                    'value' => Yii::$app->db->createCommand("Select * from {{%mbr_classify_dm}} where id = $model->classification_id")->queryOne()['description'],
                    'title' => Yii::t('app', 'Classification')
                ],
                'address',
                'email:email',
                'phone',
                [
                    'attribute' => 'status',
                    'value' => $model::STATUS_ACTIVE ? 'Activo' : 'Bloqueado'
                ],
                [
                    'attribute' => 'created_at',
                    'value' => date('Y-m-d H:i:s', $model->created_at),
                    'label' => Yii::t('app', 'Created At')
                ],
                [
                    'attribute' => 'updated_at',
                    'value' => date('Y-m-d H:i:s', $model->created_at),
                    'label' => Yii::t('app', 'Updated At')
                ],
            ],
            'options' => ['class' => 'table table-striped table-bordered detail-view table-responsive']
        ])
        ?>
    </div>
    <div class="col-xl-5 col-md-5 col-sm-5">
        <h4 class="heading"><?= Yii::t('app', 'Checkout Stats') ?></h4>
        <table class="table table-striped table-bordered detail-view table-responsive">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle">Material</th>
                    <th rowspan="2" style="vertical-align: middle"><?= Yii::t('app', 'Count') ?></th>
                    <th colspan="2" style="text-align: center"><?= Yii::t('app', 'Limits') ?></th>
                </tr>
                <tr>
                    <th>
                        <?= Yii::t('app', 'Checkout') ?>
                    </th>
                    <th>
                        <?= Yii::t('app', 'Renewal') ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    foreach ($materialType as $material):
                        ?>
                <tr>
                        <td><?= $material->description ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                </tr>      
                        <?php
                    endforeach;
                    ?>
                
            </tbody>
        </table>
    </div>
</div>
