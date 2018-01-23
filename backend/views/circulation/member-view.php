<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\jui\Accordion;
use kartik\sidenav\SideNav;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// emulación de data-confirm en elemento "a"
$js = "\$('#member_delete a').on('click', function(e) {
        a = confirm('" . Yii::t('app', 'Are you sure you want to delete this item?') . "');
        return a;
    });";
$this->registerJs($js);

$this->registerJsFile("@web/js/modal.js", ['depends' => ['yii\web\YiiAsset']]);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?=
            $this->render('_sidenav');
            ?>
            <?=
            SideNav::widget([
                'type' => SideNav::TYPE_PRIMARY,
                'heading' => $model->username,
                'items' => [
                    ['label' => Yii::t("circulation", "Account"), 'url' => ['member-account/index', 'mbr_id' => $model->id]],
                    ['label' => Yii::t('app', 'Update'), 'url' => ['circulation/member-update', 'id' => $model->id]],
                    ['label' => Yii::t('app', 'Delete'), 'url' => ['circulation/member-delete', 'id' => $model->id],
                        'options' => ['id' => 'member_delete']],
                    ['label' => Yii::t('app', 'History'), 'url' => ['circulation/member-history', 'id' => $model->id]],
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="col-xl-9 col-md-9 col-sm-9">
        <div class="col-xl-6 col-md-6 col-sm-6">
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
                    'pin',
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
                        'value' => function($model) {
                            switch ($model->status) {
                                case $model::STATUS_ACTIVE:
                                    return Yii::t('app', 'Active');
                                case $model::STATUS_BLOCKED:
                                    return Yii::t('app', 'Blocked');
                                case $model::STATUS_DELETED:
                                    return Yii::t('app', 'Deleted');
                            }
                        }
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
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h4 class="heading"><?= Yii::t('app', 'Checkout Stats') ?></h4>

            <table class="table table-striped table-bordered detail-view table-responsive">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align: middle"><?= Html::encode('Material') ?></th>
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
                    foreach ($materialTypeStats as $material):
                        ?>
                        <tr>
                            <td><?= Html::encode($material['description']) ?></td>
                            <td><?= Html::encode($material['row_count']) ?></td>
                            <td><?= Html::encode($material['checkout_limit']) ?></td>
                            <td><?= Html::encode($material['renewal_limit']) ?></td>
                        </tr>      
                        <?php
                    endforeach;
                    ?>

                </tbody>
            </table>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?=
            Accordion::widget([
                'items' => [
                    [
                        'header' => Yii::t('app', 'Bibliographies Currently Checked Out'),
                        'content' => $this->render('checkout/index', [
                            'searchModel' => $biblioCopySearch[0],
                            'dataProvider' => $biblioCopy[0],
                            'id' => $model->id
                        ]),
                    ],
                    [
                        'header' => Yii::t('app', 'Bibliographies Currently On Hold'),
                        'headerOptions' => ['tag' => 'h3'],
                        'content' => $this->render('placehold/index', [
                            'searchModel' => $biblioCopySearch[1],
                            'dataProvider' => $biblioCopy[1],
                            'id' => $model->id
                        ]),
                    ],
                ],
                'options' => ['tag' => 'div'],
                'itemOptions' => ['tag' => 'div'],
                'headerOptions' => ['tag' => 'h3'],
                'clientOptions' => ['collapsible' => false],
            ]);
            ?>
        </div>
    </div>
    <?php
    // modal checkout
    yii\bootstrap\Modal::begin([
        'header' => '<span id="modalHeaderTitle"></span>',
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'modal',
        'size' => 'modal-lg',
        'closeButton' => ['class' => 'close'],
        //keeps from closing modal with esc key or by clicking out of the modal.
        // user must click cancel or X to close
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
    ]);
    #Pjax::begin(['id' => 'pjax', 'timeout' => 500]);
    echo "<div id='modalContent'></div>";
    #Pjax::end();
    yii\bootstrap\Modal::end();
    ?>
</div>
