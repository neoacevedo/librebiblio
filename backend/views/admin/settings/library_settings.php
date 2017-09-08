<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BiblioCopySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/settings', 'Library Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="settings-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="settings-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, "library_name") ?>

        <?= $form->field($model, "library_image_url") ?>

        <?= $form->field($model, "use_image_flg") ?>

        <?= $form->field($model, "library_hours") ?>

        <?= $form->field($model, "library_phone") ?>

        <?= $form->field($model, "purge_history_after_months") ?>

        <?= $form->field($model, "block_checkouts_when_fines_due")->dropDownList(['Y' => Yii::t('app', 'Yes'), 'N' => Yii::t('app', 'No')]) ?>

        <?= $form->field($model, "hold_max_days") ?>
        
        <?= $form->field($model, "offline")->dropDownList(['1' => Yii::t('app', 'Yes'), '0' => Yii::t('app', 'No')]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Cancel'), ['admin/settings'], ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
