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

//top,新規作成画面
Route::get('/', function () {
    return view('contents/event_create');
});
Route::post('/', 'EventController@create');

//イベント情報表示画面
Route::get('/event/info/{hash_value}', 'EventController@showInfo');

//イベント編集画面
Route::get('/event/edit', 'EventController@showEditInfo');
Route::post('/event/edit', 'EventController@edit');

//エラー画面
Route::get('error', function () {
    return view('errors/error');
});

// 認証機能
Auth::routes();

// ログイン成功画面
Route::get('/home', 'HomeController@index')->name('home');
