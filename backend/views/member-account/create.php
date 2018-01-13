<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MemberAccount */

$this->title = Yii::t('circulation', 'Create Member Account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('circulation', 'Member Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
