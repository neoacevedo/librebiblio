<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MemberAccount */

$this->title = Yii::t('circulation', 'Create Member Account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('circulation', 'Member Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-account-create">
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'transactionType' => $transactionType
            ]) ?>
        </div>
    </div>
</div>