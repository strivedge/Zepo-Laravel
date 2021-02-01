<?php

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {

    Route::get('/zepo', 'ACME\Zepo\Http\Controllers\Shop\ZepoController@index')->defaults('_config', [
        'view' => 'zepo::shop.index',
    ])->name('zepo.shop.index');

     Route::get('/about-us', 'ACME\Zepo\Http\Controllers\Shop\HomeController@aboutUs')
	    ->name('about-us')
	    ->defaults('_config', [
	        'view' => 'shop::static.about-us'
	]);

	Route::get('/contact-us', 'ACME\Zepo\Http\Controllers\Shop\HomeController@contactUs')
	    ->name('contact-us')
	    ->defaults('_config', [
	        'view' => 'shop::static.contact-us'
	]);
	Route::get('/store-directory', 'ACME\Zepo\Http\Controllers\Shop\HomeController@contactUs')
	    ->name('store-directory')
	    ->defaults('_config', [
	        'view' => 'shop::static.store-directory'
	]);
	Route::get('/covid-products', 'ACME\Zepo\Http\Controllers\Shop\HomeController@contactUs')
	    ->name('covid-products')
	    ->defaults('_config', [
	        'view' => 'shop::static.covid-products'
	]);

	Route::get('/brand', 'ACME\Zepo\Http\Controllers\Shop\BrandProductController@index')
	    ->name('brand')
	    ->defaults('_config', [
	        'view' => 'shop::static.brand'
	]);

	Route::get('/brand/{name}', 'ACME\Zepo\Http\Controllers\Shop\BrandProductController@productByBrand')
	    ->name('brand-products')
	    ->defaults('_config', [
	        'view' => 'shop::brand.brand-products'
	]);

});