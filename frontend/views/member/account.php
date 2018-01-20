<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MemberAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('circulation', 'Member Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-account-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'created_at',
            //'create_userid',
            [
                'attribute' => 'user',
                'value' => 'user.username',
                'label' => \Yii::t('app', 'Updated by')
            ],
            'transaction_type_cd',
            //'amount',
            //'description',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
