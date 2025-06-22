<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\SignupForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = $this->title;

$mbr_classify = Yii::$app->db->createCommand("Select * from {{%mbr_classify_dm}}")->queryAll();
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?>
    </h1>

    <p><?= Yii::t('app', 'Please fill out the following fields to signup:') ?>
    </p>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3">&nbsp;</div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <div class="row">
                <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6">
                    <?= $form->field($model, 'first_name')->textInput() ?>
                </div>
                <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6">
                    <?= $form->field($model, 'last_name')->textInput() ?>
                </div>
            </div>

            <?= $form->field($model, 'pin')->input('number', ['min' => 1]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'address') ?>

            <?= $form->field($model, 'phone')->textInput() ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'classification_id')->dropDownList(\yii\helpers\ArrayHelper::map($mbr_classify, 'id', 'description')) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">&nbsp;</div>
    </div>
</div>
