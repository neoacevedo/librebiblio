<?php
return [
    'id' => 'app-frontend-tests',
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\Member',
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
