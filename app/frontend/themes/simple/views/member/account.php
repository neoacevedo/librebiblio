<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MemberAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('circulation', 'Member Accounts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => 'profile'];
$this->params['breadcrumbs'][] = $this->title;
//
$this->registerJs("$('.account-view').click(function(e) {"
        . "e.preventDefault();"
        . "$('#account-view').modal('show')"
        . ".find('#modalContent')"
        . ".load($(this).attr('href'));"
        . "});");
?>
<div class="member-account-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?= $this->render('_sidenav', ['model' => $model]) ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
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
                [
                    'attribute' => 'transaction_type_cd',
                    'value' => function($model) {
                        $value = '';
                        switch ($model->transaction_type_cd) {
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
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['account-view', 'account_id' => $model->id], [
                                        'title' => Yii::t('yii', 'View'), 'class' => 'account-view'
                            ]);
                        },
                    ]
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php
// modal checkout
yii\bootstrap\Modal::begin([
    'header' => '<h3>'.Yii::t('circulation', 'Details').'</h3>',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'account-view',
    'size' => 'modal-lg',
    'closeButton' => ['class' => 'close'],
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);
#Pjax::begin(['id' => 'pjax', 'timeout' => 500]);
echo "<div id='modalContent'></div>";
#Pjax::end();
yii\bootstrap\Modal::end();
?>
