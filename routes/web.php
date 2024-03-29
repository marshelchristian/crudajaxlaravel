<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('post', 'PostController@index')->name('post.index');

Route::group(['middleware' => ['web']], function(){
	Route::resource('post','PostController');
	Route::POST('addPost','PostController@addPost');
	Route::POST('editPost','PostController@editPost');
	Route::POST('deletePost','PostController@deletePost');

	Route::resource('ajax-crud-list', 'UsersController');
	Route::post('ajax-crud-list/store', 'UsersController@store');
	Route::get('ajax-crud-list/delete/{id}', 'UsersController@destroy');
});