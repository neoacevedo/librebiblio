<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Cart');
$this->params['breadcrumbs'][] = $this->title;
$js = "\$('#cart').submit(function(e) { "
        . "e.preventDefault();"
        . "var ok = confirm('" . Yii::t('circulation', 'Before proceed, please be sure your address is correct. Is your address correct?') . "');"
        . "if(ok) {"
        . "    $(this).submit();"
        . "} else {"
        . "     window.location.href = '" . yii\helpers\Url::to(['/member/profile']) . "';"
        . "}"
        . "});";

$this->registerJs($js, \yii\web\View::POS_END);
?>
<section class="content">
    <div class="circulation-index">
        <div class="bibliosearch-index">
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <?= $this->render('_sidenav', ['model' => $model]) ?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9">
                <?= Html::beginForm(['circulation/checkout'], 'post', ['id' => 'cart']) ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function($model) {
                                return ['value' => $model->id];
                            }],
                        'barcode_nmbr',
                        [
                            'label' => Yii::t('app', 'Title'),
                            'value' => function($model) {
                                return \common\models\Biblio::findOne($model->bibid)->title;
                            }
                        ]
                    ],
                    'options' => ['class' => 'box table-responsive']
                ]);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if ($dataProvider->count > 0):
                            ?>
                            <button class="btn btn-lg btn-success btn-block" type="submit"><?= Yii::t('app', 'Procced to Checkout') ?></button>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
</section>
