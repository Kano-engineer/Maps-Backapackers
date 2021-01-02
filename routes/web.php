<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/post', 'HomeController@push')->name('push');

Route::get('/post/todo_daily','PostController@index');

Route::post('/post/send','PostController@send');

Route::get('/post/target','TargetController@index');

Route::get('/post/bookmark','BookmarkController@index');
