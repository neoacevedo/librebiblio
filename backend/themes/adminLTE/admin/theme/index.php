<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/themes', 'Themes');
$this->params['breadcrumbs'][] = $this->title;
$js = "
    \$.get('" . yii\helpers\Url::to(["admin/theme/create"]) . "', function(data) {
            \$('#create_content').append(data);
         });
    \$('#create').on('click', function(e) {
        \$('#create_content').toggle();
    });";
$this->registerJs($js);
?>
<div class="theme-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <div class="col-lg-3 col-md-3 col-sm-3">
        <?=
        $this->render("../_sidenav");
        ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <div class="row">
            <button id="create" class="btn btn-default"><?= Yii::t('app', 'Install') ?></button>
        </div>
        <div class="row">
            <div class="col-md-6" id="create_content" style="display: none;">

            </div>
        </div>
        <?php Pjax::begin(); ?>    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'name',
                'frontend',
                'active',
                'created_at',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => ' {delete}'
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
