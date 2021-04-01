<?php

return [
    [
        'key' => 'festival',
        'name' => 'Festival Product',
        'route' => 'festival.index',
        'sort' => 8,
    ], [
        'key'   => 'festival.create',
        'name'  => 'festival::app.festival.create',
        'route' => 'admin.festival.create',
        'sort'  => 1,
    ], [
        'key'   => 'festival.edit',
        'name'  => 'festival::app.festival.edit',
        'route' => 'admin.festival.edit',
        'sort'  => 2,
    ], [
        'key'   => 'festival.delete',
        'name'  => 'festival::app.festival.delete',
        'route' => 'admin.festival.delete',
        'sort'  => 3,
    ],
];