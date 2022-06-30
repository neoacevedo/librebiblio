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
    Html::button(Yii::t('app', 'Place Hold'), ['value' => yii\helpers\Url::to(['circulation/copy-search', 'id' => $id, 'status' => 'hld']),
        'title' => Yii::t('app', 'Place Hold'), 'class' => 'showModalButton btn btn-primary col-lg-12 col-md-12 col-sm-12']);
    ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => Yii::t('biblio', 'Barcode Nmbr'),
                'value' => 'biblioCopy.barcode_nmbr'
            ],
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
            [
                'label' => Yii::t('app', 'Due Back Dt'),
                'value' => 'biblioCopy.due_back_dt'
            ],
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view',
                    'delete'
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action == "view") {
                        $url = "index.php?r=cataloging/biblio/view&id=$model->bibid";
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url = "index.php?r=circulation/hold-delete&id=$model->id&mbr_id=$model->mbr_id";
                        return $url;
                    }
                },
                'template' => '{view}&nbsp;{delete}'],
        ],
    ]);
    ?>
</div>
