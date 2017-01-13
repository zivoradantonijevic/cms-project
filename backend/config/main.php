<?php
use yii\web\Request;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$baseUrlFront = str_replace('/admin', '', (new Request())->getBaseUrl());

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'common\components\BackendBootstrap', 'core\user\Bootstrap', 'cms\Bootstrap'],
    'modules' => [
        'user' => [
            'class' => 'core\user\Module',
            // restrict access to recovery and registration controllers from backend
            'as backend' => 'core\user\filters\BackendFilter',
            // Settings
            'enableRegistration' => false,
            'enableUnconfirmedLogin' => true,
        ],
    ],
    'components' => [
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
        'urlManagerFront' => [
            'class' => 'yii\web\urlManager',
            'scriptUrl' => $baseUrlFront . '/index.php',
            'baseUrl' => $baseUrlFront,
        ],
        'urlManagerBack' => [
            'class' => 'yii\web\urlManager',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'params' => $params,
];
