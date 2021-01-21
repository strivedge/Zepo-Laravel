<?php

 Route::view('/testinominal', 'testinominal::testinominal.test');

 Route::get('admin/testinominal', 'Custom\Testinominal\Http\Controllers\TestinominalController@index')->defaults('_config', ['view' => 'testinominal::testinominal.index'])->name('testinominal.index');

 Route::get('admin/addTestinominal', 'Custom\Testinominal\Http\Controllers\TestinominalController@create')->defaults('_config', ['view' => 'testinominal::testinominal.create']);

Route::get('admin/testinominal_edit/{id}', 'Custom\Testinominal\Http\Controllers\TestinominalController@edit')->defaults('_config', ['view' => 'testinominal::testinominal.edit']);

Route::get('admin/testinominal_delete/{id}', 'Custom\Testinominal\Http\Controllers\TestinominalController@destroy')->defaults('_config', ['redirect' => 'testinominal.index'])->name('testinominal_delete');

Route::post('admin/saveTestinominal', 'Custom\Testinominal\Http\Controllers\TestinominalController@store')->defaults('_config', ['redirect' => 'testinominal.index']);

Route::post('admin/updateTestinominal/{id}', 'Custom\Testinominal\Http\Controllers\TestinominalController@update')->defaults('_config', ['redirect' => 'testinominal.index'])->name('updateTestinominal');