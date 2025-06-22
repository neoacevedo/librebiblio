<?php

use \yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $member common\models\Member */
/* @var $copies array */
?>
<div class="password-reset">
    <p><?= Html::encode($member->username) ?> has checked out the following item(s):</p>
    <p><?= implode("<br />", $copies) ?></p>
    <p><?= Html::encode($member->username) ?> address: <?= Html::encode($member->address) ?></p>
</div>
