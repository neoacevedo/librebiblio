<?php

foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }
    
    $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}

$connectstr_dbhost = (null !== $connectstr_dbhost) ? $connectstr_dbhost: "localhost";
$connectstr_dbname = (null !== $connectstr_dbname) ? $connectstr_dbname: "openbiblio2";
$connectstr_dbusername = (null !== $connectstr_dbusername) ? $connectstr_dbusername: "root";
$connectstr_dbpassword = (null !== $connectstr_dbpassword) ? $connectstr_dbpassword: "";

if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
    $cache['class'] = "yii\caching\MemCache";
    $servers['host'] = 'localhost';
    $servers['port'] = 11211;
    $servers['weight'] = 100;
    $cache['servers'] = [];
    array_push($cache['servers'], $servers);
    $cache['useMemcached'] = true;
} else {
    $cache['class'] = 'yii\caching\FileCache';
}


return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => $cache,       
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "mysql:host=$connectstr_dbhost;dbname=$connectstr_dbname",
            'username' => $connectstr_dbusername,
            'password' => $connectstr_dbpassword,
            'charset' => 'utf8',
            'enableQueryCache' => true
        ],
        'session' => [
            'class' => 'yii\web\CacheSession',
            'cache' => 'cache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        //'defaultRoles' => ['admin', 'staff', 'user'],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false, //for the testing purpose, you need to enable this
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.googlemail.com', // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'nestor.acevedo.romero',
                'password' => '_*Hynt1b@_*',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
        ]
    ],
    'modules' => [
        'rbac' => [
            'class' => 'johnitvn\rbacplus\Module',
            'userModelClassName' => null,
            'userModelIdField' => 'id',
            'userModelLoginField' => 'username',
            'userModelLoginFieldLabel' => null,
            'userModelExtraDataColumls' => null,
//            'userModelExtraDataColumls' => [
//                [
//                    'attributes' => 'created_at',
//                    'value' => function($model) {
//                        return date('m/d/Y', $model->created_at);
//                    }
//                ]
//            ],
            'beforeCreateController' => null,
            'beforeAction' => function ($action) {
                $roles = \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId());
                $isAdmin = false;
                foreach ($roles as $role) {
                    if ($role->name == "admin") {
                        $isAdmin = true;
                    }
                }

                if (!$isAdmin) {
                    throw new \yii\web\ForbiddenHttpException(\Yii::t("app", "You are not allowed to perform this action."));
                }

                return $isAdmin;
            },
        ],
        'gridview' => ['class' => 'kartik\grid\Module'],
        // accesos solo administrativos a módulos específicos
        'menu' => [
            'class' => '\pceuropa\menu\Menu',
            'as access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ]
                ]
            ],
        ],
    ]
];
