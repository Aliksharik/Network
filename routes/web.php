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

Auth::routes();

Route::get('/home', 'PageController@Home')->name('home');
Route::get('/', 'PageController@Home');

Route::get('/friends','PageController@Friend')->name('friends');
Route::get('/user','PageController@UserPage')->name('user page');
Route::get('/message','PageController@Message')->name('user page');
Route::get('/deleteBlog','UserController@getDeleteBlog')->name('delete blog');
Route::get('/addFollow','UserController@getAddFollow');
Route::get('/lostInFollow','UserController@getLostInFollow');
Route::get('/deleteFollow','UserController@getDeleteFollow');
Route::get('/deleteFriend','UserController@getDeleteFriend')->name('delete friend');
Route::get('/news','PageController@News')->name('news');

Route::post('/addBlog','UserController@postAddBlog')->name('addBlock');
Route::post('/message','UserController@postSendMessage')->name('send message');
