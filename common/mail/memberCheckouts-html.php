<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $member common\models\Member */
/* @var $copies array */
?>
<div class="password-reset">
    <p><?= Html::encode($member->username) ?> has checked out the following item(s):</p>
    <?php
    $copies_barcode = array_values($copies);
    ?>
    <p><?= implode("<br />", $copies_barcode) ?></p>
    <p><?= Html::encode($member->username) ?> address: <?= Html::encode($member->address) ?></p>
</div>
