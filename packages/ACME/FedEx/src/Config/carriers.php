<?php

return [
    'fedex' => [
        'code'         => 'fedex',
        'title'        => 'FedEx',
        'description'  => 'FedEx',
        'active'       => true,
        'default_rate' => '10',
        'type'         => 'per_unit',
        'class'        => 'ACME\FedEx\Carriers\FedEx',
    ],
];