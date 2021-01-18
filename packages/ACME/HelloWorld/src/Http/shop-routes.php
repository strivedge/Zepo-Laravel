<?php

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {

    Route::get('/helloworld', 'ACME\HelloWorld\Http\Controllers\Shop\HelloWorldController@index')->defaults('_config', [
        'view' => 'helloworld::shop.index',
    ])->name('helloworld.shop.index');

});