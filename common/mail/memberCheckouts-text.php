<?php
/* @var $this yii\web\View */
/* @var $member common\models\Member */
/* @var $copies array */
?>
<?= Html::encode($member->username) ?> has checked out the following item(s):

<?php
$copies_barcode = array_values($copies);
?>

<?= implode("\n", $copies_barcode) ?>

<?= Html::encode($member->username) ?> address: <?= Html::encode($member->address) ?>