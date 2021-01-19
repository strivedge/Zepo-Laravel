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

        'zmart' => [
            'views_path' => 'resources/themes/zmart/views',
            'assets_path' => 'public/themes/zmart/assets',
            'name' => 'Zmart',
            'parent' => 'default'
        ],

        'demotheme' => [
            'views_path' => 'resources/themes/demotheme/views',
            'assets_path' => 'public/themes/demotheme/assets',
            'name' => 'Demo Theme',
            'parent' => 'default'
        ],
    ],

    //'admin-default' => 'default',
    'admin-default' => 'admin-zepomart',

    'admin-themes' => [
        'default' => [
            'views_path' => 'resources/admin-themes/default/views',
            'assets_path' => 'public/admin-themes/default/assets',
            'name' => 'Default'
        ],

        'admin-zepomart' => [
            'views_path' => 'resources/admin-themes/zepomart/views',
            'assets_path' => 'public/admin-themes/zepomart/assets',
            'name' => 'Admin Zepomart'
          ]
    ]
];