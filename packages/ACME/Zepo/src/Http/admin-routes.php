<?php

Route::group(['middleware' => ['web', 'admin']], function () {

    Route::get('/admin/zepo', 'ACME\Zepo\Http\Controllers\Admin\ZepoController@index')->defaults('_config', [
        'view' => 'zepo::admin.index',
    ])->name('zepo.admin.index');

});