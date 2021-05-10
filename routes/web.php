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

//Kesiswaan
Route::get('/home/kesiswaan/{extracurricular_id}', 'HomeController@detailKesiswaan');

//ekstrakurikuler
Route::post('/extracurricular/create','ExtracurricularController@create_ekskul')->name('ekskul.create');
Route::post('/extracurricular/update','ExtracurricularController@update_ekskul')->name('ekskul.update');
Route::post('/extracurricular/status','ExtracurricularController@update_status_ekskul')->name('ekskul.status');
Route::post('/extracurricular/delete','ExtracurricularController@delete_ekskul')->name('ekskul.delete');

//Member
Route::post('/extracurricular/create_member','ExtracurricularController@create_member')->name('member.create');
Route::post('/extracurricular/update_member','ExtracurricularController@update_member')->name('member.update');
Route::post('/extracurricular/delete_member','ExtracurricularController@delete_member')->name('member.delete');

//Achievement
Route::post('/extracurricular/create_achievement','ExtracurricularController@create_achievement')->name('achievement.create');
Route::post('/extracurricular/update_achievement','ExtracurricularController@update_achievement')->name('achievement.update');
Route::post('/extracurricular/delete_achievement','ExtracurricularController@delete_achievement')->name('achievement.delete');
Route::post('/extracurricular/confirm_achievement','ExtracurricularController@confirm_achievement')->name('achievement.confirm');

//Activity
Route::post('/extracurricular/create_activity','ExtracurricularController@create_activity')->name('activity.create');
Route::post('/extracurricular/update_activity','ExtracurricularController@update_activity')->name('activity.update');
Route::post('/extracurricular/delete_activity','ExtracurricularController@delete_activity')->name('activity.delete');
Route::post('/extracurricular/confirm_activity','ExtracurricularController@confirm_activity')->name('activity.confirm');
Route::post('/extracurricular/update_detail_activity','ExtracurricularController@update_detail_activity')->name('activity.updateDetail');
