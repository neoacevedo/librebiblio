<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\sidenav\SideNav;

$this->title = Yii::t('app', 'New Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//$items = [];
//foreach (Menu::NavbarLeft(1) as $menu) {
//    $item['label'] = Yii::t('app', $menu['label']);
//    $item['url'] = $menu['url'];
//    $item['type'] = $menu['type'];
//    array_push($items, $item);
//}

$mbr_classify = Yii::$app->db->createCommand("Select * from {{%mbr_classify_dm}}")->queryAll();
?>
<div class="site-signup">
    <div class="box">
        <div class="box-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="box-body">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <div class="row">
                <div class="col-xs-4">
                    <?= $form->field($model, 'first_name')->textInput() ?>
                </div>
                <div class="col-xs-4">
                    <?= $form->field($model, 'last_name')->textInput() ?>
                </div>
            </div>
            
            <?= $form->field($model, 'pin')->input('number', ['min' => 1]) ?>

            <?= $form->field($model, 'address') ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'phone')->textInput() ?>

            <?= $form->field($model, 'classification_id')->dropDownList(\yii\helpers\ArrayHelper::map($mbr_classify, 'id', 'description')) ?>

            <div class="hidden">
                <?= $form->field($model, 'password')->hiddenInput(['value' => $model->generateUniqueRandomString(12)])->label('') ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>