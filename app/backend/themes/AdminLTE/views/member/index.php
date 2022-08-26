<?php

use common\models\Member;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Members');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-index">
    <div class="card">
        <div class="card-body">

            <?php Pjax::begin(); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'panel' => [
                    'type'=>'default',
                ],
                'toolbar' => [
                    [
                        'content' =>
                            Html::a('<i class="fas fa-plus"></i>', ['create'], [
                                'class' => 'btn btn-success',
                                'title' => Yii::t('app', 'Create Member'),
                            ])
                    ],
                ],
                'columns' => [
                    'id',
                    'username',
                    'first_name',
                    'last_name',
                    'pin',
                    'address',
                    'email:email',
                    //'status',
                    //'phone',
                    //'classification_id',
                    //'created_at',
                    //'updated_at',
                    [
                        'class' => ActionColumn::class,
                        'template' => '{view}{account}{delete}',
                        'buttons' => [
                            'account' => function ($url, $model) {
                                return Html::a(
                                    '<i class="fas fa-eye"></i>',
                                    [
                                        "/member-account/view", "mbr_id" => $model->id
                                    ],
                                    [
                                        'data-pjax' => 0,
                                        'title' => Yii::t("app", "Member Account")
                                    ]
                                );
                            }
                        ],
                        'urlCreator' => function ($action, Member $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>