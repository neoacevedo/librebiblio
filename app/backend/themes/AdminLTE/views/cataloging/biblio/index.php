<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\Collection;
use common\models\MaterialType;

/* @var $this yii\web\View */

/** @var common\models\BiblioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Biblios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblio-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]);
    ?>
    <div class="card">
        <div class="card-body">
            <?php Pjax::begin(); ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'panel' => [
                        'type' => 'default',
                    ],
                    'toolbar' => [
                        [
                            'content' =>
                                Html::a('<i class="fas fa-plus"></i>', ['create'], [
                                    'class' => 'btn btn-success',
                                    'title' => Yii::t('app', 'Create Biblio'),
                                ])
                        ],
                    ],
                    'columns' => require_once '_columns.php',
                    'options' => ['class' => 'table-responsive']
                ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>