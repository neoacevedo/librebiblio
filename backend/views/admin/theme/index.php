<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ThemeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/themes', 'Themes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['admin/settings']];
$this->params['breadcrumbs'][] = $this->title;
$js = "
    \$.get('" . yii\helpers\Url::to(["admin/theme/create"]) . "', function(data) {
            \$('#create_content').append(data);
         });
    \$('#create').on('click', function(e) {
        \$('#create_content').toggle();
    });
    
    $('.theme-active').each(function(index) {
        $(this).change(function() {
            var formid = $(this).data('formid');
            $('#'+formid).submit();
        });
    });";
$this->registerJs($js);
?>
<div class="theme-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-3 col-md-3 col-sm-3">
        <?=
        $this->render("../_sidenav");
        ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <button id="create" class="btn btn-default btn-block"><?= Yii::t('app', 'Install') ?></button>
            </div>
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
                [
                    'attribute' => 'frontend',
                    'label' => Yii::t('app/themes', 'Location'),
                    'filter' => [1 => 'Frontend', 0 => 'Backend'],
                    'value' => function($model) {
                        return ($model->frontend == 1) ? 'Frontend' : 'Backend';
                    }
                ],
                [
                    'attribute' => 'active',
                    'label' => Yii::t('app', 'Status'),
                    'filter' => [1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')],
                    'format' => 'raw',
                    'value' => function($model) {
                        
                        return $this->render('_update', ['model' => $model]);

                        //return ($model->active == 1) ? Yii::t('app/theme', 'Active') : Yii::t('app/theme', 'Inactive');
                    }
                ],
                'created_at:datetime',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}'
                ],
            ],
        ]);
        ?>
<?php Pjax::end(); ?>
    </div>
