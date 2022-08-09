<?php

/** @var yii\bootstrap4\ActiveForm $form */
/** @var yii\bootstrap4\Html */
/** @var \common\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

Yii::$app->controller->layout = 'main-login';

$this->title = "Login Form";
?>

<div class="login">
    <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

    <h1><?= Html::encode($this->title) ?>
    </h1>

    <?= $form->field($model, 'username')
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

    <?= $form->field($model, 'password')
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

    <div>
        <?= Html::submitButton(Yii::t("app", 'Login'), ['class' => 'btn btn-default submit']) ?>
        <a class="reset_pass" href="#"><?= Yii::t("app", 'Lost your password?') ?></a>
    </div>

    <div class="clearfix"></div>

    <div class="separator">
        <div class="clearfix"></div>
        <br />
        <div>
            <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
            <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>