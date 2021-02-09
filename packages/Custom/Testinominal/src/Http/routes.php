<?php

Route::view('/testinominal', 'testinominal::testinominal.test');

Route::group(['middleware' => ['admin']], function () {
	Route::prefix('admin')->group(function () {
		Route::prefix('testinominal')->group(function () {
			Route::get('/', 'Custom\Testinominal\Http\Controllers\TestinominalController@index')->defaults('_config', ['view' => 'testinominal::testinominal.index'])->name('testinominal.index');

			Route::get('/create', 'Custom\Testinominal\Http\Controllers\TestinominalController@create')->defaults('_config', ['view' => 'testinominal::testinominal.create'])->name('admin.testinominal.create');

			Route::get('/edit/{id}', 'Custom\Testinominal\Http\Controllers\TestinominalController@edit')->defaults('_config', ['view' => 'testinominal::testinominal.edit'])->name('admin.testinominal.edit');

			Route::post('/delete/{id}', 'Custom\Testinominal\Http\Controllers\TestinominalController@destroy')->defaults('_config', ['redirect' => 'testinominal.index'])->name('admin.testinominal.delete');

			Route::post('/save', 'Custom\Testinominal\Http\Controllers\TestinominalController@store')->defaults('_config', ['redirect' => 'testinominal.index'])->name('admin.testinominal.save');

			Route::post('/update/{id}', 'Custom\Testinominal\Http\Controllers\TestinominalController@update')->defaults('_config', ['redirect' => 'testinominal.index'])->name('admin.testinominal.update');

			Route::post('/masssdelete', 'Custom\Testinominal\Http\Controllers\TestinominalController@massDestroy')->name('admin.testinominal.massdelete');
		});
	});
});