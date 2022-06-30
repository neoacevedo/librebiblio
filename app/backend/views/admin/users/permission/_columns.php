<?php

use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'attribute' => 'name',
        'label' => $searchModel->attributeLabels()['name'],
    ],
    [
        'attribute' => 'description',
        'label' => $searchModel->attributeLabels()['description'],
    ],
    /* [
      'label' => $searchModel->attributeLabels()['ruleName'],
      'value' => function($model){
      return $model->ruleName==null?Yii::t('app/rbac','(not use)'):$model->ruleName;
      }
      ], */
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign' => 'middle',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action, 'name' => $key]);
        },
        'template' => '{view}&nbsp;&nbsp;{update}',
        'viewOptions' => ['role' => 'modal-remote', 'title' => Yii::t('app/rbac', 'View'), 'data-toggle' => 'tooltip'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => Yii::t('app/rbac', 'Update'), 'data-toggle' => 'tooltip'],
    /* 'deleteOptions' => ['role' => 'modal-remote', 'title' => Yii::t('app/rbac','Delete'),
      'data-confirm' => false, 'data-method' => false, // for overide yii data api
      'data-request-method' => 'post',
      'data-toggle' => 'tooltip',
      'data-comfirm-ok'=>Yii::t('app/rbac','Ok'),
      'data-comfirm-cancel'=>Yii::t('app/rbac','Cancel'),
      'data-confirm-title' => Yii::t('app/rbac','Are you sure?'),
      'data-confirm-message' => Yii::t('app/rbac','Are you sure want to delete this item')], */
    ],
];
