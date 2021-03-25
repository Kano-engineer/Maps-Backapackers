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

// ゲストログイン
Route::get('/login/guest', 'Auth\LoginController@guestLogin');

//プロフィール表示
Route::get('/profile', 'ProfileController@index');
//画像を保存したり画像名をDBに格納する部分
Route::post('/profile/upload', 'ProfileController@upload');
//プロフィール画像削除
Route::delete('/profile/{id}', 'ProfileController@destroy');
//プロフィール
Route::get('/profile/{id}', 'ProfileController@show');

//ピン詳細:{{pins->id}}をcontrollerに渡す
Route::get('/post/{id}','PinController@show',);

//ピン詳細ページで写真をDB保存
Route::post('/store/{id}','PhotoController@upload',);

// ピン：写真の消去
Route::delete('/pin/{id}', 'PhotoController@destroy');

// ピン：文章の削除
Route::delete('/pin/text/{id}', 'PinController@destroy');

// ピン編集➡︎地図再検索
Route::get('/edit/{id}', 'PinController@edit');

// ピン更新
Route::POST('/update/{id}', 'PinController@update');

//リアルタムチャット 
Route::get('post', 'ChatsController@index');
Route::get('messages', 'ChatsController@fetchMessages');
Route::post('messages', 'ChatsController@sendMessage');

// プライベートチャンネルをリッスンする場合、channels.phpに許可ルールを記述する必要があります。
Broadcast::channel('chat', function ($user) {
    return Auth::check();
});


// ピン：コメント作成
Route::post('/comment/{id}','PinController@comment');

// ピン：コメント削除
Route::delete('/comment/{id}', 'PinController@destroyComment');

// プロフィール：コメント作成
Route::post('/profile/comment/{id}','ProfileController@comment');

// プロフィール：コメント削除
Route::delete('/profile/comment/{id}', 'ProfileController@destroyComment');

// いいね機能
Route::post('posts/{pin}/favorites', 'FavoriteController@store')->name('favorites');
Route::post('posts/{pin}/unfavorites', 'FavoriteController@destroy')->name('unfavorites');

// フォロー機能
Route::post('/users/{user}/follow', 'FollowUserController@follow')->name('follow');
Route::post('/users/{user}/unfollow', 'FollowUserController@unfollow')->name('unfollow');

// map
Route::get('/map', 'HomeController@map')->name('map');
Route::get('/map2', 'HomeController@map2')->name('map2');
Route::get('/map3', 'HomeController@map3')->name('map3');

// ピン作成：テキスト保存
Route::post('/post','PinController@post');

// Formに遷移
Route::get('/form','HomeController@form');

// 検索
Route::get('/books', 'HomeController@search');
Route::get('/index', function () {
    return view('index');
});