<?php

Route::group(['middleware' => ['web', 'admin']], function () {

    Route::get('/admin/helloworld', 'ACME\HelloWorld\Http\Controllers\Admin\HelloWorldController@index')->defaults('_config', [
        'view' => 'helloworld::admin.index',
    ])->name('helloworld.admin.index');

    Route::get('admin/helloworld/create', 'ACME\HelloWorld\Http\Controllers\Admin\HelloWorldController@create')->defaults('_config', [
                'view' => 'helloworld::admin.create',
            ])->name('helloworld.admin.create');

});