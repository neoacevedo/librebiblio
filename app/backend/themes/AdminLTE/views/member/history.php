<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Member */

$this->title = Yii::t('app', 'Member Checkouts History: ') . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['/circulation/index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['member/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'History');
?>
<div class="user-update">
    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => Yii::t('biblio', 'Barcode Nmbr'),
                        'value' => function ($model) {
                            return common\models\BiblioCopy::findOne($model->copyid)->barcode_nmbr;
                        }
                    ],
                    [
                        'label' => Yii::t('app', 'Title'),
                        'value' => function ($model) {
                            return common\models\Biblio::findOne($model->bibid)->title;
                        }
                    ],
                    [
                        'label' => Yii::t('app', 'Author'),
                        'value' => function ($model) {
                            return common\models\Biblio::findOne($model->bibid)->author;
                        }
                    ],
                    [
                        'label' => Yii::t('app', 'Status Cd'),
                        'value' => function ($model) {
                            return common\models\BiblioStatusDm::findOne($model->status_cd)->description;
                        }
                    ],
                    [
                        'label' => Yii::t('library', 'Date'),
                        'value' => function ($model) {
                            return $model->created_at;
                        }
                    ]
                ]
            ]) ?>
        </div>
    </div>

</div>