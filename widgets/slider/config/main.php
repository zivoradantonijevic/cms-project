<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

return [
    'title' => 'Slider',
    'config' => [
        'class' => 'widgets\slider\SliderWidget',
        'title' => '',
        'group' => '',
        'count' => 1,
    ],
    'description' => 'Simple widget to show slider.',
    'page' => __DIR__ . '/../views/option.php',
];
