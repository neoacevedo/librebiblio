<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BiblioCopySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Biblio Copies');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-copy-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <a href="<?= \yii\helpers\Url::to(["biblio-copy/copies-print"]) ?>" target="_blank" class="btn btn-block btn-primary"><?= Yii::t('cataloging', 'Print List') ?></a>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'bibid',
            'created_at',
            'updated_at',
            'copy_desc',
            // 'barcode_nmbr',
            // 'status_cd',
            // 'status_begint_dt',
            // 'due_back_dt',
            // 'mbr_id',
            // 'renewal_count',
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'options' => [
            'class' => 'table table-striped table-bordered table-responsive'
        ],
    ]);
    ?>
</div>
