<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'core\user\Module',
            'admins' => ['superadmin'],
            // Yii2 User Controllers Overrides
        ],
        'btool-core' => [
            'class' => 'btool\core\Module',
        ],
        'btool-odds' => [
            'class' => 'btool\odds\Module',
        ],
    ],
];
