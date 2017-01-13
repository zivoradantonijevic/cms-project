<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

/*if (!Yii::$app->user->can('author')) {
    return [];
}*/
return [
    'backend' => [
        'adminMenu' => [
            70 => [
                'label' => Yii::t('app', 'Sliders'),
                'url' => ['/slider/slider/index'],
                'icon' => 'fa fa-dollar',
                'items' => [
                    [
                        'label' => Yii::t('app', 'Adverts'),
                        'url' => ['/slider/slider/index'],
                        'icon' => 'fa fa-circle-o'
                    ],
                    [
                        'label' => Yii::t('app', 'Add New Advert'),
                        'url' => ['/slider/slider/create'],
                        'icon' => 'fa fa-circle-o'
                    ],
                    [
                        'label' => Yii::t('app', 'Groups'),
                        'url' => ['/slider/slider-group/index'],
                        'icon' => 'fa fa-circle-o'
                    ],
                ]
            ],
        ],
    ],
];
