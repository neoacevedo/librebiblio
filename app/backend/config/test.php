<?php
return [
    'id' => 'app-backend-tests',
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'backend\models\User',
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
