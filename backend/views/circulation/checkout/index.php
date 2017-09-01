<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="biblio-index">     
    <?=
    Html::button(Yii::t('app', 'Check Out'), ['value' => yii\helpers\Url::to(['circulation/copy-search', 'id' => $id, 'status' => 'out']),
        'title' => Yii::t('app', 'Check Out'), 'class' => 'showModalButton btn btn-primary col-lg-12 col-md-12 col-sm-12']);
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'barcode_nmbr',
            [
                'label' => Yii::t('app', 'Title'),
                'value' => function($model) {
                    return \common\models\Biblio::findOne(["id" => $model->bibid])->title;
                }//
            ],
            [
                'label' => Yii::t('app', 'Author'),
                'value' => function($model) {
                    return \common\models\Biblio::findOne(["id" => $model->bibid])->author;
                }//
            ],
            [
                'attribute' => 'material_cd',
                'value' => function($model) {
                    $biblio = \common\models\Biblio::findOne(["id" => $model->bibid]);
                    return \backend\models\MaterialType::findOne(['id' => $biblio->material_cd])->description;
                },
                'label' => 'Material'
            ],
            'due_back_dt',
            'renewal_count',
            [
                'label' => Yii::t('app', 'Days Late'),
                'value' => function($model) {
                    $datetime1 = new DateTime($model->due_back_dt);
                    $datetime2 = new DateTime('now');
                    $interval = $datetime1->diff($datetime2);
                    $cero = 0;
                    $diff = (int)$interval->format('%r%a');
                    return max($cero, $diff);
                    //greatest(0,to_days(sysdate()) - to_days(biblio_copy.due_back_dt)) days_late
                }
            ]
        /* ['class' => 'yii\grid\ActionColumn',
          'buttons' => [
          'renew-item' => function($url, $model) {
          return Html::a('<span class="glyphicon glyphicon-reload"></span>', ['renew-item', 'id' => $model->id], [
          'title' => Yii::t('app', 'Renew item'),
          'id' => "modal"
          ]);
          }
          ]], */
        ],
    ]);
    ?>
</div>

