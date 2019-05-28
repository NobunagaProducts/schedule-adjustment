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

//Route::get('/', function () {
//    return view('welcome');
//});


//top,新規作成画面
Route::get('/', function (){
    return view('top');
});
Route::post('/', 'EventController@create');

//イベント情報表示画面
Route::get('/event/info?{eventid}', 'EventController@showInfo');

//イベント編集画面
Route::get('/event/edit?{eventid}', 'EventController@showEditInfo');
Route::post('/event/edit?{eventid}', 'EventController@edit');
