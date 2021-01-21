<?php

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {

    Route::get('/helloworld', 'ACME\HelloWorld\Http\Controllers\Shop\HelloWorldController@index')->defaults('_config', [
        'view' => 'helloworld::shop.index',
    ])->name('helloworld.shop.index');

   /* Route::get('/about-us', 'ACME\HelloWorld\Http\Controllers\Shop\HelloWorldController@contactUs')->defaults('_config', [
        'view' => 'helloworld::shop.index',
    ])->name('helloworld.shop.static.about-us');*/

    Route::get('/about-us', 'ACME\HelloWorld\Http\Controllers\Shop\HelloWorldController@aboutUs')
	    ->name('about-us')
	    ->defaults('_config', [
	        'view' => 'shop::static.about-us'
	]);

	 Route::get('/contact-us', 'ACME\HelloWorld\Http\Controllers\Shop\HelloWorldController@contactUs')
	    ->name('contact-us')
	    ->defaults('_config', [
	        'view' => 'shop::static.contact-us'
	]);

    
});