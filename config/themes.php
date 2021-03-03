<?php

return [
    'default' => 'default',

    'themes' => [
        'default' => [
            'views_path' => 'resources/themes/default/views',
            'assets_path' => 'public/themes/default/assets',
            'name' => 'Default'
        ],

        // 'bliss' => [
        //     'views_path' => 'resources/themes/bliss/views',
        //     'assets_path' => 'public/themes/bliss/assets',
        //     'name' => 'Bliss',
        //     'parent' => 'default'
        // ]

        'velocity' => [
            'views_path' => 'resources/themes/velocity/views',
            'assets_path' => 'public/themes/velocity/assets',
            'name' => 'Velocity',
            'parent' => 'default'
        ],

        'bodywave' => [
            'views_path' => 'resources/themes/bodywave/views',
            'assets_path' => 'public/themes/bodywave/assets',
            'name' => 'Bodywave',
            'parent' => 'velocity'
        ],
    ],

    'admin-default' => 'bodywave',

    'admin-themes' => [
        'default' => [
            'views_path' => 'resources/admin-themes/default/views',
            'assets_path' => 'public/admin-themes/default/assets',
            'name' => 'Default'
        ],
        'bodywave' => [
            'views_path' => 'resources/admin-themes/bodywave/views',
            'assets_path' => 'public/admin-themes/bodywave/assets',
            'name' => 'BodyWave'
        ]
    ]
];