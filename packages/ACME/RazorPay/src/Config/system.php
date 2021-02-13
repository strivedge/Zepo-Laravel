<?php

return [
    [
        'key'    => 'sales.paymentmethods.razorpay',
        'name'   => 'RazorPay',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'admin::app.admin.system.title',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'description',
                'title'         => 'admin::app.admin.system.description',
                'type'          => 'textarea',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'active',
                'title'         => 'admin::app.admin.system.status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ],[
                 'name'          => 'sandbox',
                 'title'         => 'admin::app.admin.system.sandbox',
                 'type'          => 'boolean',
                 'validation'    => 'required',
                 'channel_based' => false,
                 'locale_based'  => true,
            ], [
                 'name'    => 'sort',
                 'title'   => 'admin::app.admin.system.sort_order',
                 'type'    => 'select',
                 'options' => [
                     [
                         'title' => '1',
                         'value' => 1,
                     ], [
                         'title' => '2',
                         'value' => 2,
                     ], [
                         'title' => '3',
                         'value' => 3,
                     ], [
                         'title' => '4',
                         'value' => 4,
                     ],
                 ],
            ]
        ]
    ]
];