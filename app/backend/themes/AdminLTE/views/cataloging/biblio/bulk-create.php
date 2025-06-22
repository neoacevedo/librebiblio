<?php

use common\models\Collection;
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
                    "class" => 'form-control col-4',
                    'prompt' => '--',
                    'label' => Yii::t('app', 'Material Cd'),
                    'required' => true
                ]) ?>
            </div>
            <div class="form-group">
                <label for=""><?= Yii::t('app', 'Collection Cd') ?></label>
                <?= Html::dropDownList("collection_cd", null, Collection::asArray(), [
                    "class" => 'form-control col-4',
                    'prompt' => '--',
                    'label' => Yii::t('app', 'Collection Cd'),
                    'required' => true
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
            <div class="table-responsive">
                <?=
                    GridView::widget(
                        [
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'label' => Yii::t("app", "Material Cd"),
                                    'value' => function ($model) {
                                        return $model['material_cd'];
                                    }
                                ],
                                [
                                    'label' => Yii::t("app", "Collection Cd"),
                                    'value' => function ($model) {
                                        return $model['collection_cd'];
                                    }
                                ],
                                [
                                    'label' => Yii::t("app", "Title"),
                                    'value' => function ($model) {
                                        return $model['title'];
                                    }
                                ],
                                [
                                    'label' => Yii::t("app", "Title Remainder"),
                                    'value' => function ($model) {
                                        return $model['title_remainder'];
                                    }
                                ],
                                [
                                    'label' => Yii::t("app", "Call Nmbr"),
                                    'value' => function ($model) {
                                        return "{$model['call_nmbr1']} {$model['call_nmbr2']} {$model['call_nmbr3']}";
                                    }
                                ],
                                [
                                    'label' => Yii::t("app", "Responsibility Stmt"),
                                    'value' => function ($model) {
                                        return $model['responsibility_stmt'];
                                    }
                                ],
                                [
                                    'label' => Yii::t("app", "Author"),
                                    'value' => function ($model) {
                                        return $model['author'];
                                    }
                                ],
                                [
                                    'label' => Yii::t("app", "Topical Term"),
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        $html = Html::beginTag("ul");
                                        $html .= $model['topic1'] != "" ? Html::tag("li", $model['topic1']) : "";
                                        $html .= $model['topic2'] != "" ? Html::tag("li", $model['topic2']) : "";
                                        $html .= $model['topic3'] != "" ? Html::tag("li", $model['topic3']) : "";
                                        $html .= $model['topic4'] != "" ? Html::tag("li", $model['topic4']) : "";
                                        $html .= $model['topic5'] != "" ? Html::tag("li", $model['topic5']) : "";
                                        $html .= Html::endTag("ul");

                                        return $html;
                                    }
                                ],
                                [
                                    'label' => Yii::t("biblio", "USMarc Fields:"),
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        $arrayDataProvider = new \yii\data\ArrayDataProvider([
                                            'allModels' => $model['usmarc'],
                                        ]);
                                        $html = GridView::widget([
                                            'dataProvider' => $arrayDataProvider,
                                            'columns' => [
                                                [
                                                    'label' => Yii::t("app", "Tag"),
                                                    'value' => function ($model) {
                                            return $model['tag'];
                                        }
                                                ],
                                                [
                                                    'label' => Yii::t("cataloging", "Subfield Cd"),
                                                    'value' => function ($model) {
                                            return $model['subfield_cd'];
                                        }
                                                ],
                                                [
                                                    'label' => Yii::t("cataloging", "Field Data"),
                                                    'value' => function ($model) {
                                            return $model['field_data'];
                                        }
                                                ]
                                            ]
                                        ]);

                                        return $html;
                                    }
                                ],
                            ]
                        ]
                    ) ?>
            </div>

        </div>
    </div>
</div><!-- cataloging-biblio-field-bulk-create -->