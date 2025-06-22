<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioCopySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('biblio', 'Biblio Copies');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-copy-index">
    <p>
        <a href="<?= \yii\helpers\Url::to(["biblio-copy/copies-print"]) ?>"
            target="_blank" class="btn btn-block btn-primary"><?= Yii::t('cataloging', 'Print List') ?></a>
    </p>
    <div class="card">
        <div class="card-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'barcode_nmbr',
                    [
                        'attribute' => 'bibid',
                        'label' => Yii::t('app', 'Title'),
                        'value' => function ($model) {
                            return $model->biblio->title;
                        }
                    ],
                    'created_at',
                    'updated_at',
                    'copy_desc',
                    [
                        'class' => 'kartik\grid\ActionColumn',
                    ],
                ],
                'options' => [
                    'class' => 'table table-striped table-bordered table-responsive'
                ],
            ]);
?>
        </div>
    </div>
</div>