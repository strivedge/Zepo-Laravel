<?php

Route::view('/offer', 'offer::offer.test');

Route::get('admin/offers', 'Custom\Offer\Http\Controllers\OfferController@index')->defaults('_config', ['view' => 'offer::offer.index'])->name('offer.index');

Route::get('admin/addOffer', 'Custom\Offer\Http\Controllers\OfferController@create')->defaults('_config', ['view' => 'offer::offer.create'])->name('addOffer');

Route::get('admin/offer_edit/{id}', 'Custom\Offer\Http\Controllers\OfferController@edit')->defaults('_config', ['view' => 'offer::offer.edit'])->name('offer_edit');

Route::post('admin/offer_delete/{id}', 'Custom\Offer\Http\Controllers\OfferController@destroy')->defaults('_config', ['redirect' => 'offer.index'])->name('offer_delete');

Route::post('admin/saveOffer', 'Custom\Offer\Http\Controllers\OfferController@store')->defaults('_config', ['redirect' => 'offer.index']);

Route::post('admin/updateOffer/{id}', 'Custom\Offer\Http\Controllers\OfferController@update')->defaults('_config', ['redirect' => 'offer.index'])->name('updateOffer');

Route::post('admin/offer_masssdelete', 'Custom\Offer\Http\Controllers\OfferController@massDestroy')->name('offer_masssdelete');

Route::post('admin/offer_masssupdate', 'Custom\Offer\Http\Controllers\OfferController@massUpdate')->name('offer_masssupdate');