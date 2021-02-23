<?php

Route::group(['middleware' => ['web', 'admin']], function () {

    Route::get('/admin/zepo', 'ACME\Zepo\Http\Controllers\Admin\ZepoController@index')->defaults('_config', [
        'view' => 'zepo::admin.index',
    ])->name('zepo.admin.index');

    Route::get('/admin/support-ticket', 'ACME\Zepo\Http\Controllers\Admin\SupportTicketController@index')->defaults('_config', [
        'view' => 'zepo::admin.support-ticket.index',
    ])->name('zepo.support-ticket.index');

    Route::get('/admin/edit/{id}', 'ACME\Zepo\Http\Controllers\Admin\SupportTicketController@edit')->defaults('_config', [
    	'view' => 'zepo::admin.support-ticket.edit'
    ])->name('zepo.support-ticket.edit');

    Route::post('/admin/update/{id}', 'ACME\Zepo\Http\Controllers\Admin\SupportTicketController@update')->defaults('_config', [
    	'redirect' => 'zepo.support-ticket.index'
    ])->name('zepo.support-ticket.update');

    Route::post('/admin/delete/{id}', 'ACME\Zepo\Http\Controllers\Admin\SupportTicketController@destroy')->defaults('_config', [
    	'redirect' => 'zepo.support-ticket.index'
    ])->name('zepo.support-ticket.delete');

    Route::post('/admin/masssdelete', 'ACME\Zepo\Http\Controllers\Admin\SupportTicketController@massDestroy')->name('zepo.support-ticket.massdelete');

});