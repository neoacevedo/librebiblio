<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\Nav;

/** @var yii\web\View $this */
/** @var \common\models\Member $model */
/** @var \common\models\BiblioCopySearch[] $biblioCopySearch */
/** @var \common\models\BiblioCopy[] $biblioCopy */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// emulación de data-confirm en elemento "a"
$js = "\$('#member_delete a').on('click', function(e) {
        a = confirm('" . Yii::t('yii', 'Are you sure you want to delete this item?') . "');
        return a;
    });";
$this->registerJs($js);

$this->registerJsFile("@web/js/modal.js", ['depends' => ['yii\web\YiiAsset']]);
?>
<div class="user-view">
    <div class="card">
        <nav class="navbar navbar-expand navbar-white navbar-light">
            <?= Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => [
                    ['label' => Yii::t("circulation", "Account"), 'url' => ['member-account/index', 'mbr_id' => $model->id]],
                    ['label' => Yii::t('yii', 'Update'), 'url' => ['member/update', 'id' => $model->id]],
                    [
                        'label' => Yii::t('app', 'Delete'),
                        'url' => ['member/delete', 'id' => $model->id],
                        'options' => ['id' => 'member_delete']
                    ],
                    ['label' => Yii::t('app', 'History'), 'url' => ['member/history', 'BiblioStatusHistorySearch[mbr_id]' => $model->id]],
                ]
            ]); ?>
        </nav>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <?= DetailView::widget([
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
                                'value' => function ($model) {
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
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="heading">
                        <?= Yii::t('app', 'Checkout Stats') ?>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered detail-view table-responsive">
                        <thead>
                            <tr>
                                <th rowspan="2" style="vertical-align: middle">
                                    <?= Html::encode('Material') ?>
                                </th>
                                <th rowspan="2" style="vertical-align: middle">
                                    <?= Yii::t('app', 'Count') ?>
                                </th>
                                <th colspan="2" style="text-align: center">
                                    <?= Yii::t('app', 'Limits') ?>
                                </th>
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
                            <?php foreach ($materialTypeStats as $material): ?>
                                <tr>
                                    <td>
                                        <?= Html::encode($material['description']) ?>
                                    </td>
                                    <td>
                                        <?= Html::encode($material['row_count']) ?>
                                    </td>
                                    <td>
                                        <?= Html::encode($material['checkout_limit']) ?>
                                    </td>
                                    <td>
                                        <?= Html::encode($material['renewal_limit']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="checked-out-tab" data-bs-toggle="tab"
                                data-bs-target="#checked-out-tab-pane"><?= Yii::t('app', 'Bibliographies Currently Checked Out') ?></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="placehold-tab" data-bs-toggle="tab"
                                data-bs-target="#placehold-tab-pane"><?= Yii::t('app', 'Bibliographies Currently On Hold') ?></button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="bibliography-tabContent">
                        <div class="tab-pane fade active show" role="tabpanel" id="checked-out-tab-pane"
                            aria-labelledby="checked-out-tab">
                            <?= $this->render('/circulation/checkout/index', [
                                'searchModel' => $biblioCopySearch[0],
                                'dataProvider' => $biblioCopy[0],
                                'id' => $model->id
                            ]) ?>
                        </div>
                        <div class="tab-pane fade" role="tabpanel" id="placehold-tab-pane"
                            aria-labelledby="placehold-tab">
                            <?= $this->render('/circulation/placehold/index', [
                                'searchModel' => $biblioCopySearch[1],
                                'dataProvider' => $biblioCopy[1],
                                'id' => $model->id
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// modal checkout
yii\bootstrap5\Modal::begin([
    'title' => '',
    'id' => 'modal',
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);
#Pjax::begin(['id' => 'pjax', 'timeout' => 500]);
echo "<div id='modalContent'></div>";
#Pjax::end();
yii\bootstrap5\Modal::end();
