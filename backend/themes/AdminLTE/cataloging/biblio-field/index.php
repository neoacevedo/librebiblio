<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Biblio */
/* @var $searchModel common\models\BiblioFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cataloging', 'Biblio Fields');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Biblios'), 'url' => ['cataloging/biblio/index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-field-index">
    <div class="box">
        <div class="box-header">
            <h1><?= Html::encode($this->title . " | ". $model->title) ?></h1>
        </div>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="box-body">
            <p>
                <?= Html::a(Yii::t('cataloging', 'Create MARC Field'), ['create', 'bibid' => $model->id], ['class' => 'btn btn-success']) ?>
            </p>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'bibid',
                    //'fieldid',
                    'tag',
                    'ind1_cd',
                    'ind2_cd',
                    'subfield_cd',
                    'field_data:ntext',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>

