<?php

use common\models\BiblioStatusHistory;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\BiblioStatusHistorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */



$this->title = Yii::t('app', 'Member Checkouts History: ') . $searchModel->member->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['/circulation/index']];
$this->params['breadcrumbs'][] = ['label' => $searchModel->member->username, 'url' => ['member/view', 'id' => $searchModel->member->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'History');
?>
<div class="user-update">
    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => Yii::t('biblio', 'Barcode Nmbr'),
                        'value' => function (BiblioStatusHistory $model) {
                                        return $model->biblioCopy->barcode_nmbr;
                                    }
                    ],
                    [
                        'label' => Yii::t('app', 'Title'),
                        'value' => function (BiblioStatusHistory $model) {
                                        return $model->biblio->title;
                                    }
                    ],
                    [
                        'label' => Yii::t('app', 'Author'),
                        'value' => function (BiblioStatusHistory $model) {
                                        return $model->biblio->author;
                                    }
                    ],
                    [
                        'label' => Yii::t('app', 'Status Cd'),
                        'value' => function (BiblioStatusHistory $model) {
                                        return common\models\BiblioStatusDm::findOne($model->status_cd)->description;
                                    }
                    ],
                    [
                        'label' => Yii::t('library', 'Date'),
                        'value' => function (BiblioStatusHistory $model) {
                                        return $model->created_at;
                                    }
                    ]
                ]
            ]) ?>
        </div>
    </div>

</div>