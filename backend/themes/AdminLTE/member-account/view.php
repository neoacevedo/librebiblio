<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MemberAccount */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('circulation', 'Member Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-account-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('circulation', 'Update'), ['update', 'id' => $model->id, 'mbr_id' => $model->mbr_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('circulation', 'Delete'), ['delete', 'id' => $model->id, 'mbr_id' => $model->mbr_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('circulation', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'mbr_id',
            'created_at',
            'create_userid',
            'transaction_type_cd',
            'amount',
            'description',
        ],
    ]) ?>

</div>
