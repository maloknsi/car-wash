<?php
//https://github.com/hiqdev/yii2-theme-sailor
//https://yiiframework.ru/forum/viewtopic.php?t=43674
$db = yii\helpers\ArrayHelper::merge(require __DIR__ . '/db.php',(file_exists(__DIR__ . '/db-local.php')?(require __DIR__ . '/db-local.php'):[]));
$params = yii\helpers\ArrayHelper::merge(require __DIR__ . '/params.php',(file_exists(__DIR__ . '/params-local.php')?(require __DIR__ . '/params-local.php'):[]));

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'language' => 'ru-RU',
	'charset'=>'UTF-8',
	'timeZone'=>'Europe/Kiev',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@vendor/bower/clockpicker/dist' => '@vendor/bower-asset/clockpicker/dist',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
	    'authManager' => [
		    'class' => 'yii\rbac\PhpManager',
		    'defaultRoles' => ['admin', 'user', 'operator'],
	    ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'cJBH7Pe4Ds54TbpxMF6Fvr_iHLhKsSjb',
        ],
        'cache' => [
            //'class' => 'yii\caching\FileCache',
            'class' => 'yii\caching\DummyCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
	        'loginUrl' => ['site/index'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error-page',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
	            '/logout' => '/site/logout',
	            '/login' => '/site/login',
	            '/' => 'site/index',

	            '<controller>/<action>/<id>' => '<controller>/<action>',
	            '<controller>/<action>' => '<controller>/<action>'
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
