<?php
Route::group(['middleware' => ['admin']], function () {
	Route::prefix('admin')->group(function () {
		Route::prefix('festival')->group(function () {
			Route::get('/', 'Custom\Festival\Http\Controllers\FestivalController@index')->defaults('_config', ['view' => 'festival::festival.index'])->name('festival.index');

			Route::get('/create', 'Custom\Festival\Http\Controllers\FestivalController@create')->defaults('_config', ['view' => 'festival::festival.create'])->name('admin.festival.create');

			Route::get('/edit/{id}', 'Custom\Festival\Http\Controllers\FestivalController@edit')->defaults('_config', ['view' => 'festival::festival.edit'])->name('admin.festival.edit');

			Route::post('/delete/{id}', 'Custom\Festival\Http\Controllers\FestivalController@destroy')->defaults('_config', ['redirect' => 'festival.index'])->name('admin.festival.delete');

			Route::post('/save', 'Custom\Festival\Http\Controllers\FestivalController@store')->defaults('_config', ['redirect' => 'festival.index'])->name('admin.festival.save');

			Route::post('/update/{id}', 'Custom\Festival\Http\Controllers\FestivalController@update')->defaults('_config', ['redirect' => 'festival.index'])->name('admin.festival.update');

			Route::post('/masssdelete', 'Custom\Festival\Http\Controllers\FestivalController@massDestroy')->name('admin.festival.massdelete');

			Route::post('/masssupdate', 'Custom\Festival\Http\Controllers\FestivalController@massUpdate')->name('admin.festival.massupdate');
		});
	});
});