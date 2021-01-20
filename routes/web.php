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

//下記を追記
//画像をアップロードするページ
Route::get('/upload', 'ImageController@input');
//画像を保存したり画像名をDBに格納する部分
Route::post('/upload', 'ImageController@upload');
//保存した画像を表示するページ
Route::get('/output', 'ImageController@output');
//上記までを追記

// ピン作成：テキスト保存
Route::post('/post','PinController@post');

//ピン詳細:{{pins->id}}をcontrollerに渡す
Route::get('post/{id}','PinController@show',);

//ピン詳細ページで写真をDB保存
Route::get('post/photo/{id}','PhotoController@store',);