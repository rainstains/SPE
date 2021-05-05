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
Route::get('/adduser', 'Auth\AddUserController@index')->name('adduser');
Route::post('/adduser/adduser', 'Auth\AddUserController@create')->name('adduser.create');

Route::get('/home', 'HomeController@index')->name('home');

//ekstrakurikuler
Route::get('/ekstrakurikuler/create_page','EkskulController@create_page');
Route::post('/ekstrakurikuler/create','EkskulController@create_ekskul')->name('ekskul.create');
Route::post('/ekstrakurikuler/delete','EkskulController@delete_ekskul')->name('ekskul.delete');
