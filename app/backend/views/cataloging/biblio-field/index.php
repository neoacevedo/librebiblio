<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */
/* @var $searchModel common\models\BiblioFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cataloging', 'Biblio Fields');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['cataloging/biblio/index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['cataloging/biblio/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-field-index">
    <div class="card">
        <div class="card-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'panel' => [
                    'type'=>'default',
                ],
                'toolbar' => [
                    [
                        'content' =>
                            Html::a('<i class="fas fa-plus"></i>', ['create', 'bibid' => $model->id], [
                                'class' => 'btn btn-success',
                                'title' => Yii::t('app', 'Create MARC Field'),
                            ])
                    ],
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'bibid',
                    //'fieldid',
                    'tag',
                    //'ind1_cd',
                    //'ind2_cd',
                    'subfield_cd',
                    'field_data:ntext',
                    ['class' => 'yii\grid\ActionColumn', 'template' => '{update}&nbsp;&nbsp;{delete}'],
                ],
            ]);
?>
        </div>
    </div>
</div>