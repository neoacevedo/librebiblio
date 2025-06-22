<?php

use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Member */
$this->title = Yii::t('app', 'Cart');
$this->params['breadcrumbs'][] = $this->title;

$js = "var keys = [];"
        . "\$('.checkbox').each(function(idx){ "
        . "     $(this).click(function() {"
        . "         keys = $('#cart').yiiGridView('getSelectedRows');"
        . "         $('.selection').remove();"
        . "         keys.forEach(function(val, idx, array) {"
        . "             $('<input>').attr({type: 'hidden', name: 'selection[]', value: val, class: 'selection' }).appendTo('#form');"
        . "         });"
        . "     });"
        . "});"
        . "\$('#checkBox input[type=checkbox]').click(function() {"
        . "     if($(this).is(':checked')) { "
        . "         var checked = $('.checkbox');"
        . "         checked.each(function(index, value) {"
        . "             $('<input>').attr({type: 'hidden', name: 'selection[]', value: $(this).val(), class: 'selection' }).appendTo('#form');"
        . "             keys[index] = $(this).val();"
        . "         });"
        . "     } else {"
        . "         $('.selection').remove();"
        . "         keys = [];"
        . "     }"
        . "});"
        . "\$('#submit').click(function() { "
        . "     if(keys.length > 0) {"
        . "         $( '#dialog-confirm' ).dialog('open');"
        . "     } else {"
        . "         alert('" . Yii::t('app', 'You must select at least one element') . "');"
        . "     }"
        . "});";

$this->registerJs($js, \yii\web\View::POS_END);
?>
<section class="content">
    <div class="circulation-index">
        <div class="bibliosearch-index">
            <h1><?= Html::encode($this->title) ?>
            </h1>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <?= $this->render('_sidenav', ['model' => $model]) ?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'multiple' => true,
                            'checkboxOptions' => function ($model) {
                                return ['class' => 'checkbox', 'value' => $model->copyid];
                            },
                            'headerOptions' => [
                                'id' => 'checkBox'
                            ]
                        ],
                        [
                            'label' => Yii::t('biblio', 'Barcode Nmbr'),
                            'value' => function ($model) {
                                return $model->biblioCopy->barcode_nmbr;
                            }
                        ],
                        [
                            'label' => Yii::t('app', 'Title'),
                            'value' => function ($model) {
                                return $model->biblio->title;
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}'
                        ],
                    ],
                    'options' => ['class' => 'box table-responsive', 'id' => 'cart']
                ]);
?>
                <?= Html::beginForm(['circulation/checkout'], 'post', ['id' => 'form']) ?>

                <?= Html::endForm() ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php
        if ($dataProvider->count > 0):
            ?>
                        <button class="btn btn-lg btn-success btn-block" id="submit"><?= Yii::t('app', 'Procced to Checkout') ?></button>
                        <?php
        endif;
?>
                    </div>
                </div>

            </div>
            <?php
            Dialog::begin([
                'id' => 'dialog-confirm',
                'clientOptions' => [
                    'modal' => true,
                    'autoOpen' => false,
                    'resizable' => false,
                    'height' => 'auto',
                    'width' => '400px',
                    'buttons' => [
                        [
                            'text' => Yii::t('app', 'Yes'),
                            'click' => new yii\web\JsExpression(
                                ''
                                    . 'function(){ '
                                    . '     $("#form").submit();'
                                    . '}'
                            )
                        ],
                        [
                            'text' => Yii::t('app', 'No'),
                            'click' => new yii\web\JsExpression('function(){window.location.href = "' . yii\helpers\Url::to(['/member/profile']) . '"}')
                        ]
                    ],
                ],
            ]);
echo Yii::t('circulation', 'Before proceed, please be sure your address is correct. {address}<br /> Is your address correct?', ['address' => $model->address]);
Dialog::end();
?>
        </div>
</section>