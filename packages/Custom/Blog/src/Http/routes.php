<?php

Route::view('/blogs', 'blog::blog.blog');
// Route::get('admin/blogTest', 'Custom\Blog\Http\Controllers\BlogController@index')->defaults('_config', ['view' => 'blog::blog.blog'])->name('blog.blog');

// Admin Side
// Admin Routes
Route::group(['middleware' => ['admin']], function () {
	Route::get('admin/blog', 'Custom\Blog\Http\Controllers\BlogController@index')->defaults('_config', ['view' => 'blog::blog.index'])->name('blog.index');

	Route::get('admin/addBlog', 'Custom\Blog\Http\Controllers\BlogController@create')->defaults('_config', ['view' => 'blog::blog.create'])->name('addBlog');

	Route::get('admin/blog_edit/{id}', 'Custom\Blog\Http\Controllers\BlogController@edit')->defaults('_config', ['view' => 'blog::blog.edit'])->name('blog_edit');

	Route::post('admin/blog_delete/{id}', 'Custom\Blog\Http\Controllers\BlogController@destroy')->defaults('_config', ['redirect' => 'blog.index'])->name('blog_delete');

	Route::post('admin/saveBlog', 'Custom\Blog\Http\Controllers\BlogController@store')->defaults('_config', ['redirect' => 'blog.index']);

	Route::post('admin/updateBlog/{id}', 'Custom\Blog\Http\Controllers\BlogController@update')->defaults('_config', ['redirect' => 'blog.index'])->name('blog_update');

	Route::post('admin/blog_masssdelete', 'Custom\Blog\Http\Controllers\BlogController@massDestroy')->name('blog_masssdelete');
});