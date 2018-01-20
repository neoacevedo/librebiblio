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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'mbr_id',
            'created_at',
            [
                'attribute' => 'user',
                'value' => 'user.username',
                'label' => \Yii::t('app', 'Updated by')
            ],
            'transaction_type_cd',
            'amount',
            'description',
        ],
    ]) ?>

</div>
