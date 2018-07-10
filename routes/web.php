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
var_dump(route());

Route::domain('blog.reaulkarim.com')->group(function () {
	Route::get('/','PostController@index')->name('home');;

	Auth::routes();

	Route::resource('posts', 'PostController');
	Route::post('posts/{post}/comments', 'CommentsController@store');
	Route::post('posts/{post}/like', 'LikeController@store');

	Route::get('t/{tag}','PostController@tags');
});

