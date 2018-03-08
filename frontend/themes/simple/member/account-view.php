<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MemberAccount */
?>
<div class="member-account-view">
    <?=
    DetailView::widget([
        'model' => $memberAccount,
        'attributes' => [
            'id',
            'mbr_id',
            'created_at',
            [
                'attribute' => 'transaction_type_cd',
                'value' => function($model) {
                    $value = '';
                    switch ($model->transaction_type_cd) {
                        case '+c':
                            $value = Yii::t('circulation', 'Charge');
                            break;
                        case '+p':
                            $value = Yii::t('circulation', 'Payment');
                            break;
                        case '-c':
                            $value = Yii::t('circulation', 'Credit');
                            break;
                    }

                    return $value;
                }
            ],
            'amount',
            'description',
        ],
    ])
    ?>
    <div class="row">
        <div class="col-xs-12" style="text-align: center;">
            <div class="col-xs-4">&nbsp;</div>
            <div class="col-xs-4">
                <a href="<?= \yii\helpers\Url::to(["member/account-print", 'id' => $memberAccount->id, "mbr_id" => $memberAccount->mbr_id]) ?>" target="_blank" class="btn btn-block btn-primary">
                    <i class="glyphicon glyphicon-print"></i>
                    <?= Yii::t('app', 'Print') ?>
                </a>
            </div>
            <div class="col-xs-4">&nbsp;</div>
        </div>
    </div>
</div>
