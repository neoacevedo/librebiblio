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
    Html::button(Yii::t('app', 'Check Out'), ['value' => yii\helpers\Url::to(['circulation/checkout', 'id' => $id]),
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
                    return $model->getBiblio()->title;
                }//\common\models\Biblio::findOne(["id" => $model->bibid])->title
            ],
            [
                'label' => Yii::t('app', 'Author'),
                'value' => function($model) {
                    return $model->getBiblio()->author;
                }//\common\models\Biblio::findOne(["id" => $model->bibid])->author
            ],
            [
                'attribute' => 'material_cd',
                'value' => function($model) {
                    return \backend\models\MaterialType::findOne(['id' => $model->getBiblio()->material_cd])->description;
                },
                'label' => 'Material'
            ],
            'due_back_dt',
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

