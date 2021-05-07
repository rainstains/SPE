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
/*
Route::get('/', function () {
    return view('auth/login');
});
*/
Route::get('/', 'HomeController@index');

//Auth::routes();
Auth::routes([
    'register' => false,
]);
Route::post('/adduser', 'Auth\AddUserController@create')->name('adduser.create');

Route::get('/home', 'HomeController@index')->name('home');

//ekstrakurikuler
Route::post('/extracurricular/create','ExtracurricularController@create_ekskul')->name('ekskul.create');
Route::post('/extracurricular/update','ExtracurricularController@update_ekskul')->name('ekskul.update');
Route::post('/extracurricular/status','ExtracurricularController@update_status_ekskul')->name('ekskul.status');
Route::post('/extracurricular/delete','ExtracurricularController@delete_ekskul')->name('ekskul.delete');
Route::post('/extracurricular/add_member','ExtracurricularController@add_member')->name('member.add');
Route::post('/extracurricular/edit_member','ExtracurricularController@edit_member')->name('member.edit');
Route::post('/extracurricular/delete_member','ExtracurricularController@delete_member')->name('member.delete');
