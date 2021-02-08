<?php

Route::view('/blogs', 'blog::blog.blog');
// Route::get('admin/blogTest', 'Custom\Blog\Http\Controllers\BlogController@index')->defaults('_config', ['view' => 'blog::blog.blog'])->name('blog.blog');

// Admin Side
// Admin Routes
Route::group(['middleware' => ['admin']], function () {
	Route::prefix('admin')->group(function () {
		Route::prefix('blog')->group(function () {
			Route::get('/', 'Custom\Blog\Http\Controllers\BlogController@index')->defaults('_config', ['view' => 'blog::blog.index'])->name('blog.index');

			Route::get('/create', 'Custom\Blog\Http\Controllers\BlogController@create')->defaults('_config', ['view' => 'blog::blog.create'])->name('admin.blog.create');

			Route::get('/edit/{id}', 'Custom\Blog\Http\Controllers\BlogController@edit')->defaults('_config', ['view' => 'blog::blog.edit'])->name('admin.blog.edit');

			Route::post('/delete/{id}', 'Custom\Blog\Http\Controllers\BlogController@destroy')->defaults('_config', ['redirect' => 'blog.index'])->name('admin.blog.delete');

			Route::post('/save', 'Custom\Blog\Http\Controllers\BlogController@store')->defaults('_config', ['redirect' => 'blog.index'])->name('admin.blog.save');

			Route::post('/update/{id}', 'Custom\Blog\Http\Controllers\BlogController@update')->defaults('_config', ['redirect' => 'blog.index'])->name('admin.blog.update');

			Route::post('/masssdelete', 'Custom\Blog\Http\Controllers\BlogController@massDestroy')->name('admin.blog.massdelete');
		});
	});
});