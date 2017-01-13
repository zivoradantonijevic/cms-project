<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

return [
    'name' => 'slider',
    'title' => 'Sliders',
    'description' => 'Module for Sliders',
    'config' => [
        'backend' => [
            'class' => 'modules\slider\backend\Module',
        ],
        'frontend' => [
            'class' => 'modules\slider\frontend\Module',
        ],
    ],
    'backend_bootstrap' => 1,
];
