<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

return [
    'name' => 'banner',
    'title' => 'Banners',
    'description' => 'Module for Banners',
    'config' => [
        'backend' => [
            'class' => 'modules\banner\backend\Module',
        ],
        'frontend' => [
            'class' => 'modules\banner\frontend\Module',
        ],
    ],
    'backend_bootstrap' => 1,
];
