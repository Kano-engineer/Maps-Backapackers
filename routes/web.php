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
    return view('top');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//マイプロフィール画面へ遷移
Route::get('/home/myprofile', 'HomeController@showMyProfile')->name('profile');


Route::get('/post', 'HomeController@push')->name('push');

//todoとdiary作成画面へ遷移
Route::get('/post/todo_diary','PostController@index');

//todoとdiary作成して、画面遷移
Route::post('/post/todo_diary','PostController@post');

//todoとdiary作成完了画面へ遷移
Route::get('/post/send','PostController@send');

Route::get('/post/target','TargetController@index');

Route::get('/post/bookmark','BookmarkController@index');

//timelineを表示
Route::get('/post/timeline','PostController@showTimeline')->name('showTimeline');

//timelineのコメントを表示
Route::get('/post/comment/{id}','PostController@showComment')->name('showComment');

//timelineのコメント投稿
Route::post('/post/comment/{id}','PostController@postComment');

//ユーザープロフィール画面へ遷移
Route::get('/userprofile/{id}', 'HomeController@showUserProfile')->name('userprofile');
