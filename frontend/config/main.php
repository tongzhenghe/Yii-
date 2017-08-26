<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'layout'=>false,//
    //'defaultRoute' => 'home/login',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
//        'user' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
//        ],
        'user' => [//实现用户登陆配置
            'identityClass' => \frontend\models\Member::className(),
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class'=>'yii\web\UrlManager',//指定实现类
            'enablePrettyUrl' => true,//开启url美化: 是否使用pathinfo模式访问以及生成URL地址设置为true则表示使用pathinfo方式
            'showScriptName' => false,//是否显示index.php +还需要在Vostphp里加上这句话：try_files $uri $uri/ /index.php$is_args$args;
            'rules' => [
                'suffix' => '.html',//伪静态后缀
            ],
        ],

    ],
    'params' => $params,
];
