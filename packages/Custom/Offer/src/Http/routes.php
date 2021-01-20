<?php

Route::view('/offer', 'offer::offer.test');

Route::get('admin/offers', 'Custom\Offer\Http\Controllers\OfferController@index')->defaults('_config', ['view' => 'offer::offer.index'])->name('offer.index');
Route::get('admin/addOffer', 'Custom\Offer\Http\Controllers\OfferController@create')->defaults('_config', ['view' => 'offer::offer.create']);
Route::get('admin/offer_edit/{id}', 'Custom\Offer\Http\Controllers\OfferController@edit')->defaults('_config', ['view' => 'offer::offer.edit']);
Route::get('admin/offer_delete/{id}', 'Custom\Offer\Http\Controllers\OfferController@destroy')->defaults('_config', ['redirect' => 'offer.index'])->name('offer_delete');
Route::post('admin/saveOffer', 'Custom\Offer\Http\Controllers\OfferController@store')->defaults('_config', ['redirect' => 'offer.index']);
Route::post('admin/updateOffer/{id}', 'Custom\Offer\Http\Controllers\OfferController@update')->defaults('_config', ['redirect' => 'offer.index'])->name('update');