<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('circulation', 'Place holds');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => 'profile'];
$this->params['breadcrumbs'][] = $this->title;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="biblio-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-lg-3 col-md-3 col-sm-3">
<?= $this->render('_sidenav', ['model' => $model]) ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => Yii::t('app', 'Barcode Nmbr'),
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
                        'delete'
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        $url = ["/circulation/hold-delete", 'id' => $model->id];
                        return $url;
                    },
                    'template' => '{delete}'],
            ],
        ]);
        ?>
    </div>
</div>
