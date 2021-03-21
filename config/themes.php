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

        'smart-shop' => [
            'views_path' => 'resources/themes/smart-shop/views',
            'assets_path' => 'public/themes/smart-shop/assets',
            'name' => 'Smart Shop',
            'parent' => 'velocity'
        ],
    ],

    'admin-default' => 'smart-shop',

    'admin-themes' => [
        'default' => [
            'views_path' => 'resources/admin-themes/default/views',
            'assets_path' => 'public/admin-themes/default/assets',
            'name' => 'Default'
        ],
        'smart-shop' => [
            'views_path' => 'resources/admin-themes/smart-shop/views',
            'assets_path' => 'public/admin-themes/smart-shop/assets',
            'name' => 'Smart Shop'
        ]
    ]
];