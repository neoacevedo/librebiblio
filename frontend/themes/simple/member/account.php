<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'Account');
?>
<div class="member-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?= $this->render('_sidenav', ['model' => $model]) ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'username',
                'first_name',
                'last_name',
                [
                    'attribute' => 'classification',
                    'value' => Yii::$app->db->createCommand("Select * from {{%mbr_classify_dm}} where id = $model->classification_id")->queryOne()['description'],
                    'title' => Yii::t('app', 'Classification')
                ],
                'address',
                'email:text',
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
</div>

