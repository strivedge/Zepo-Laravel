<?php

Route::view('/offer', 'offer::offer.test');

Route::get('admin/offer', 'Custom\Offer\Http\Controllers\OfferController@index')->defaults('_config', ['view' => 'offer::offer.index'])->name('offer.index');