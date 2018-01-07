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

Route::group([
  'namespace' => 'AbbyJanke\Blog\app\Http\Controllers\Admin',
  'prefix' => config('backpack.base.route_prefix', 'admin').'/blog',
  'middleware' => ['web', 'admin'],
], function () {
  CRUD::resource('article', 'ArticleCrudController');
  Route::post('category/create_quick', 'CategoryCrudController@quickSave');
  CRUD::resource('category', 'CategoryCrudController');
  Route::post('tag/create_quick', 'TagCrudController@quickSave');
  CRUD::resource('tag', 'TagCrudController');
});
