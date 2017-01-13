<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

return [
    'backend' => [
        'menu' => [
            'location' => [
                'primary' => 'Primary',
            ],
        ],
        'postType' => [
            'post' => [
                'meta' => [
                    ['class' => 'themes\writesdown\classes\meta\Meta'],
                ],
                'support' => [],
            ],
            'page' => [
                'meta' => [
                    ['class' => 'themes\writesdown\classes\meta\Meta'],
                ],
                'support' => [],
            ],
        ],
        'widget' => [
            [
                'title' => 'Sidebar Left',
                'description' => 'Main sidebar that appears on the left.',
                'location' => 'sidebar-left',
            ],
            [
                'title' => 'Sidebar Second Left',
                'description' => 'Main sidebar that appears on the left in second column.',
                'location' => 'sidebar-left-2',
            ],
            [
                'title' => 'Sidebar Right',
                'description' => 'Main sidebar that appears on the right.',
                'location' => 'sidebar-right',
            ],
            [
                'title' => 'Sidebar Second Right',
                'description' => 'Main sidebar that appears on the right in second column.',
                'location' => 'sidebar-right-2',
            ],
            [
                'title' => 'Homepage',
                'description' => 'Main sidebar that appears on homepage.',
                'location' => 'homepage',
            ],
            /*            [
                            'title' => 'Footer Middle',
                            'description' => 'Appears on the middle of footer',
                            'location' => 'footer-middle',
                        ],
                        [
                            'title' => 'Footer Right',
                            'description' => 'Appears on the right of footer',
                            'location' => 'footer-right',
                        ],*/
        ],
    ],
];
