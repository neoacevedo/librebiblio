<?php

use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\BiblioField $model */
/** @var ActiveForm $form */

$this->title = Yii::t('cataloging', 'Upload MARC Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['cataloging/biblio/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cataloging-biblio-field-bulk-create">
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['entype' => "multipart/form-data"]]); ?>
            <div class="form-group">
                <div class="form-inline">
                    <strong>Test load:</strong>&nbsp;&nbsp;
                    <?= Html::radioList("test", "1", [1 => Yii::t("yii", "Yes"), 0 => Yii::t("yii", "No")], ['tag' => false, 'separator' => '&nbsp;&nbsp;&nbsp;']) ?>
                </div>
            </div>
            <div class="form-group">
                <label for="">USMarc Input File:</label>
                <?= Html::fileInput("usmarc_data", null, ['required' => true, "accept" => "text/csv"]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('yii', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div><!-- cataloging-biblio-field-bulk-create -->