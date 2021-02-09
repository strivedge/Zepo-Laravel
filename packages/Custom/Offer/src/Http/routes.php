<?php

Route::view('/offer', 'offer::offer.test');

Route::group(['middleware' => ['admin']], function () {
	Route::prefix('admin')->group(function () {
		Route::prefix('offer')->group(function () {
			Route::get('/', 'Custom\Offer\Http\Controllers\OfferController@index')->defaults('_config', ['view' => 'offer::offer.index'])->name('offer.index');

			Route::get('/create', 'Custom\Offer\Http\Controllers\OfferController@create')->defaults('_config', ['view' => 'offer::offer.create'])->name('admin.offer.create');

			Route::get('/edit/{id}', 'Custom\Offer\Http\Controllers\OfferController@edit')->defaults('_config', ['view' => 'offer::offer.edit'])->name('admin.offer.edit');

			Route::post('/delete/{id}', 'Custom\Offer\Http\Controllers\OfferController@destroy')->defaults('_config', ['redirect' => 'offer.index'])->name('admin.offer.delete');

			Route::post('/save', 'Custom\Offer\Http\Controllers\OfferController@store')->defaults('_config', ['redirect' => 'offer.index'])->name('admin.offer.save');

			Route::post('/update/{id}', 'Custom\Offer\Http\Controllers\OfferController@update')->defaults('_config', ['redirect' => 'offer.index'])->name('admin.offer.update');

			Route::post('/masssdelete', 'Custom\Offer\Http\Controllers\OfferController@massDestroy')->name('admin.offer.massdelete');

			Route::post('/masssupdate', 'Custom\Offer\Http\Controllers\OfferController@massUpdate')->name('admin.offer.massupdate');
		});
	});
});