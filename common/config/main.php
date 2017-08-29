<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager'=>[
            'class'=>\yii\rbac\DbManager::className()
      ],
         'db' => [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=yiishop',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
       ],
    ],
];
