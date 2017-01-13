<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

return [
    'title' => 'Banner',
    'config' => [
        'class' => 'widgets\banner\BannerWidget',
        'title' => '',
        'group' => '',
        'count' => 1,
    ],
    'description' => 'Simple widget to show banner.',
    'page' => __DIR__ . '/../views/option.php',
];
