<?php

/**
 * @copyright Copyright (c) 2020 Néstor Acevedo
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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
                    'type' => 'default',
                ],
                'toolbar' => [
                    [
                        'content' =>
                            Html::a('<i class="fas fa-print"></i>', ["print"], [
                                'class' => 'btn btn-default',
                                'title' => Yii::t('circulation', 'Print List'),
                                'target' => '_blank',
                                'data-pjax' => 0,
                            ])
                            . Html::a('<i class="fas fa-plus"></i>', ['create'], [
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
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                                        switch ($model->status) {
                                            case $model::STATUS_ACTIVE:
                                                return Yii::t('app', 'Active');
                                            case $model::STATUS_BLOCKED:
                                                return Yii::t('app', 'Blocked');
                                            case $model::STATUS_DELETED:
                                                return Yii::t('app', 'Deleted');
                                        }
                                    }
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{view}&nbsp;{delete}',
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