<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
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
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['id' => 'form-signup']]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <div class="form-row">
                <div class="col">
                    <?= $form->field($model, 'first_name')->textInput(['class' => 'form-control mb-6']) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'last_name')->textInput(['class' => 'form-control mb-6']) ?>
                </div>
            </div>

            <div class="form-row">
                <div class="col">
                    <?= $form->field($model, 'address') ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'email') ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'phone')->textInput() ?>
                </div>
            </div>

            <div class="form-row">
                <div class="col">
                    <?= $form->field($model, 'pin')->input('number', ['min' => 1]) ?>
                </div>
                <div class="col">
                    <?= $form->field($model, 'classification_id')->dropDownList(\yii\helpers\ArrayHelper::map($mbr_classify, 'id', 'description')) ?>
                </div>
            </div>

            <div class="d-none">
                <?= $form->field($model, 'password')->hiddenInput(['value' => $model->generateUniqueRandomString(12)])->label('') ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t("app", 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>