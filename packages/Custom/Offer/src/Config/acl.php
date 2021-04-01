<?php

return [
    [
        'key' => 'offer',
        'name' => 'Offer',
        'route' => 'offer.index',
        'sort' => 8,
    ], [
        'key'   => 'offer.create',
        'name'  => 'offer::app.offer.create',
        'route' => 'admin.offer.create',
        'sort'  => 1,
    ], [
        'key'   => 'offer.edit',
        'name'  => 'offer::app.offer.edit',
        'route' => 'admin.offer.edit',
        'sort'  => 2,
    ], [
        'key'   => 'offer.delete',
        'name'  => 'offer::app.offer.delete',
        'route' => 'admin.offer.delete',
        'sort'  => 3,
    ],
];