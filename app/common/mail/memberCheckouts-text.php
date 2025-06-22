<?php
use \yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $member common\models\Member */
/* @var $copies array */
?>
<?= Html::encode($member->username) ?> has checked out the following item(s):

<?= implode("\n", $copies) ?>

<?= Html::encode($member->username) ?> address: <?= Html::encode($member->address) ?>