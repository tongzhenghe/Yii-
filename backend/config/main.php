<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'language'=>'zh-CN',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'defaultRoute' => 'admin/login',
    'components' => [
        //数据库配置
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=yiishop',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        /*用户组件yii\web\User 用来管理用户的认证状态。
        这需要你指定一个含有实际认证逻辑的认证类yii\web\User::identityClass。
        在以下web应用的配置项中，将用户用户组件yii\web\User 的认证类yii\web\
        User::identityClass配置成模型类
        app\models\User*/
        'user' => [//实现用户登陆配置
            'identityClass' => 'backend\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',

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
    //Edtor===============================
    'controllerMap' => [
        'ueditor' => [
            'class' => 'crazydb\ueditor\UEditorController',
        ]
    ],
//Edtor===END=============================================
];
