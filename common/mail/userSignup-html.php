<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = "http:". Yii::$app->params['baseUrlFrontend'] . '/site/reset-password?token=' . $user->password_reset_token;
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to create your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
