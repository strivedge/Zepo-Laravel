<?php

return [
    [
        'key' => 'testinominal',
        'name' => 'Testinominal',
        'route' => 'testinominal.index',
        'sort' => 9,
    ], [
        'key'   => 'testinominal.create',
        'name'  => 'testinominal::app.testinominal.create',
        'route' => 'admin.testinominal.create',
        'sort'  => 1,
    ], [
        'key'   => 'testinominal.edit',
        'name'  => 'testinominal::app.testinominal.edit',
        'route' => 'admin.testinominal.edit',
        'sort'  => 2,
    ], [
        'key'   => 'testinominal.delete',
        'name'  => 'testinominal::app.testinominal.delete',
        'route' => 'admin.testinominal.delete',
        'sort'  => 3,
    ],
];