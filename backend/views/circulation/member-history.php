<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', '{modelClass} History: ', [
            'modelClass' => 'User',
        ]) . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Circulation'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['member-view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'History');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => Yii::t('app', 'Barcode Nmbr'),
                'value' => function($model) {
                    return common\models\BiblioCopy::findOne($model->copyid)->barcode_nmbr;
                }
            ],
            [
                'label' => Yii::t('app', 'Title'),
                'value' => function($model) {
                    return common\models\Biblio::findOne($model->bibid)->title;
                }
            ],
            [
                'label' => Yii::t('app', 'Author'),
                'value' => function($model) {
                    return common\models\Biblio::findOne($model->bibid)->author;
                }
            ],
            [
                'label' => Yii::t('app', 'Status'),
                'value' => function($model) {
                    return common\models\Biblio::findOne($model->bibid)->title;
                }
            ],
        ]
    ])
    ?>


</div>
