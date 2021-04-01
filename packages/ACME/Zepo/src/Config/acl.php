<?php

return [
    // [
    //     'key' => 'zepo',
    //     'name' => 'Zepo',
    //     'route' => 'zepo.admin.index',
    //     'sort' => 2
    // ],
    [
        'key' => 'support-ticket',
        'name' => 'Support Ticket',
        'route' => 'zepo.support-ticket.index',
        'sort' => 10,
    ], [
        'key'   => 'support-ticket.view',
        'name'  => 'zepo::app.support-ticket.view',
        'route' => 'zepo.support-ticket.view',
        'sort'  => 1,
    ],
];