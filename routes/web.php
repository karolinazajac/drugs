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
Route::post('/users/edit/{id}', 'User\UsersController@edit');
Route::get('/cabinet/{id?}', 'User\CabinetController@index');
Route::get('/timetable', 'User\TimetableController@index');
Route::get('/diary', 'User\DiaryController@index');
Route::post('/diary/create-note', 'User\DiaryController@createNote');
Route::get('/stats', 'User\StatisticsController@index');
Route::get('/drugs', 'User\CabinetController@getDrugs');
Route::post('/cabinet/create', 'User\CabinetController@createCabinet');
Route::post('/cabinet/add-drug', 'User\CabinetController@addDrug');
Route::post('/cabinet/delete-drug/{id}', 'User\CabinetController@deleteDrug');
Route::post('/cabinet/edit-drug/{id}', 'User\CabinetController@editDrug');
Route::post('/cabinet/delete-user/{cabinetId}/{userId}', 'User\CabinetController@deleteCabinetUser');
Route::post('/cabinet/delete-cabinet/{id}','User\CabinetController@deleteCabinet');
Route::post('/cabinet/add-user/{cabinetId}', 'User\CabinetController@addUser');

Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin/home', 'Admin\HomeController@index');
    Route::get('/admin/users', 'Admin\UsersController@index');
    Route::get('/admin/cabinets', 'Admin\CabinetsController@index');
    Route::get('/admin/drugs', 'Admin\DrugsController@index');
    Route::post('/admin/drugs', 'Admin\DrugsController@importExcel');
});
