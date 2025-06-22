<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberClassifySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Member Classifies');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-classify-index">
    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'panel' => [
                        'type'=>'default',
                    ],
                    'toolbar' => [
                        [
                            'content' =>
                                Html::a('<i class="fas fa-plus"></i>', ['create'], [
                                    'class' => 'btn btn-success',
                                    'title' => Yii::t('app', 'Create Member Classify'),
                                ])
                        ],
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'description',
                        'max_fines',
                        ['class' => 'yii\grid\ActionColumn', 'template' => "{update}&nbsp;{delete}"],
                    ],
            ]) ?>
        </div>
    </div>
</div>