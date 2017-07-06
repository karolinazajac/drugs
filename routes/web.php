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

Auth::routes();

Route::get('/home', 'User\HomeController@index');
Route::get('/users', 'User\UsersController@index');
Route::get('/cabinet', 'User\CabinetController@index');
Route::get('/timetable', 'User\TimetableController@index');
Route::get('/diary', 'User\DiaryController@index');
Route::get('/stats', 'User\StatisticsController@index');

Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin/home', 'Admin\HomeController@index');
});