<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BiblioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Biblios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Biblio'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at',
            'updated_at',
            'updated_userid',
            'material_cd',
            // 'collection_cd',
            // 'call_nmbr1',
            // 'call_nmbr2',
            // 'call_nmbr3',
            // 'title:ntext',
            // 'title_remainder:ntext',
            // 'responsibility_stmt:ntext',
            // 'author:ntext',
            // 'topic1:ntext',
            // 'topic2:ntext',
            // 'topic3:ntext',
            // 'topic4:ntext',
            // 'topic5:ntext',
            // 'opac_flg',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
