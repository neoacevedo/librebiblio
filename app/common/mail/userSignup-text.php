<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to create your password:

<?= $resetLink ?>

This link expires in <?= (Yii::$app->params['user.passwordResetTokenExpire'] / 60 / 60) ?> hour(s)
