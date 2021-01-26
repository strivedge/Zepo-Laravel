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
	Route::get('/store-directory', 'ACME\HelloWorld\Http\Controllers\Shop\HelloWorldController@contactUs')
	    ->name('store-directory')
	    ->defaults('_config', [
	        'view' => 'shop::static.store-directory'
	]);
	Route::get('/covid-products', 'ACME\HelloWorld\Http\Controllers\Shop\HelloWorldController@contactUs')
	    ->name('covid-products')
	    ->defaults('_config', [
	        'view' => 'shop::static.covid-products'
	]);

	Route::get('/brand', 'ACME\HelloWorld\Http\Controllers\Shop\HelloWorldController@contactUs')
	    ->name('brand')
	    ->defaults('_config', [
	        'view' => 'shop::static.brand'
	]);

	Route::get('/brand/{name}', 'ACME\HelloWorld\Http\Controllers\Shop\BrandProductController@productByBrand')
	    ->name('brand-products')
	    ->defaults('_config', [
	        'view' => 'shop::brand.brand-products'
	]);

    
});