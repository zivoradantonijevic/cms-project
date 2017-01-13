<?php
use yii\web\Request;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$baseUrlBack = (new Request())->getBaseUrl() . '/admin';

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log', 'common\components\FrontendBootstrap',  'core\user\Bootstrap', 'cms\Bootstrap'],
    'modules' => [],
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
        ],
        'urlManagerBack' => [
            'class' => 'yii\web\urlManager',
            'scriptUrl' => $baseUrlBack . '/index.php',
            'baseUrl' => $baseUrlBack,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@core/user/views' => '@app/views/user',
                ],
            ],

        ],
    ],
    'params' => $params,
];
