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
    <?php
    if (isset(Yii::$app->request->queryParams['mbr_id'])):
        ?>
        <p>
            <?= Html::a(Yii::t('circulation', 'Create Member Account'), ['create', 'mbr_id' => Yii::$app->request->queryParams['mbr_id']], ['class' => 'btn btn-success']) ?>
        </p>
        <?php
    endif;
    ?>
    <div class="box">
        <div class="box-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'mbr_id',
                    'created_at',
                    //'create_userid',
                    [
                        'attribute' => 'user',
                        'value' => 'user.username',
                        'label' => \Yii::t('app', 'Updated by')
                    ],
                    [
                      'attribute' => 'transaction_type_cd',
                        'value' => function($model) {
                            $value = '';
                            switch($model->transaction_type_cd) {
                                case '+c':
                                    $value = Yii::t('circulation', 'Charge');
                                    break;
                                case '+p':
                                    $value = Yii::t('circulation', 'Payment');
                                    break;
                                case '-c':
                                    $value = Yii::t('circulation', 'Credit');
                                    break;
                            }
                            
                            return $value;
                        }
                    ],
                    //'amount',
                    //'description',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
                'options' => ['class' => 'table table-striped table-bordered table-responsive']
            ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
