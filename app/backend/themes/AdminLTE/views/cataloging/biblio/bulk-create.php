<?php

use backend\models\Collection;
use common\models\MaterialType;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var ActiveForm $form */
/** @var yii\data\ArrayDataProvider $dataProvider */

$this->title = Yii::t('cataloging', 'Upload Marc Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['cataloging/biblio/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cataloging-biblio-field-bulk-create">
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => "multipart/form-data"]]); ?>
            <div class="form-group">
                <div class="form-inline">
                    <strong><?= Yii::t("cataloging", "Test Load") ?>:</strong>&nbsp;&nbsp;
                    <?= Html::radioList("test", "1", [1 => Yii::t("yii", "Yes"), 0 => Yii::t("yii", "No")], ['tag' => false, 'separator' => '&nbsp;&nbsp;&nbsp;']) ?>
                </div>
            </div>
            <div class="form-group">
                <label for="usmarc_data">USMarc Input File:</label>
                <input type="file" name="usmarc_data" id="usmarc_data" required="true" class="form-control">
            </div>
            <div class="form-group">
                <label for=""><?= Yii::t('app', 'Material Cd') ?></label>
                <?= Html::dropDownList("material_cd", null, MaterialType::asArray(), [
                "class" => 'form-control col-4', 'prompt' => '--', 'label' => Yii::t('app', 'Material Cd'), 'required' => true
                ]) ?>
            </div>
            <div class="form-group">
                <label for=""><?= Yii::t('app', 'Collection Cd') ?></label>
                <?= Html::dropDownList("collection_cd", null, Collection::asArray(), [
                "class" => 'form-control col-4', 'prompt' => '--', 'label' => Yii::t('app', 'Collection Cd'), 'required' => true
                ]) ?>
            </div>
            <div class="form-group">
                <label for=""><?= Yii::t('app', 'Opac Flg') ?></label>
                <input type="checkbox" name="opac_flg" id="">
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('yii', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?=
                GridView::widget(
                    [
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'label' => 'Material',
                            ],
                            [
                                'label' => 'Descripción'
                            ]
                        ]
                    ]
                ) ?>
        </div>
    </div>
</div><!-- cataloging-biblio-field-bulk-create -->