<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', '{modelClass} History: ', [
            'modelClass' => 'User',
        ]) . " $model->username";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => 'profile'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?= $this->render('_sidenav', ['model' => $model]) ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
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
                'status_cd'
            ]
        ])
        ?>
    </div>
</div>
