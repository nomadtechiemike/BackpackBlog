<?php

/*
|--------------------------------------------------------------------------
| Backpack\Blog Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\Blog package.
|
*/

// Admin Routes
Route::group([
  'namespace' => 'AbbyJanke\Blog\app\Http\Controllers\Admin',
  'prefix' => config('backpack.base.route_prefix', 'admin').'/blog',
  'middleware' => ['web', 'admin'],
], function () {
  CRUD::resource('article', 'ArticleCrudController');
  Route::post('category/create_quick', 'CategoryCrudController@quickSave');
  Route::get('comment/search', 'CommentCrudController@search');
  CRUD::resource('comment', 'CommentCrudController');
  CRUD::resource('category', 'CategoryCrudController');
  Route::post('tag/create_quick', 'TagCrudController@quickSave');
  CRUD::resource('tag', 'TagCrudController');
});

// Web Routes
Route::group([
  'namespace' => 'AbbyJanke\Blog\app\Http\Controllers',
  'prefix' => config('backpack.blog.route_prefix'),
  'middleware' => ['web'],
], function () {
  Route::get('/', 'ArticleController@index')->name('blog.index');
  Route::get('post/{slug}', 'ArticleController@show')->name('blog.post');
  Route::post('post/{slig}', 'ArticleController@saveComment');
  Route::get('author/{slug}', 'AuthorController@show')->name('blog.author');

  Route::get('{type}/{slug}', 'ArticleController@index')->name('blog.sorted');
});
