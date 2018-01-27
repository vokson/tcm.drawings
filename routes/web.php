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


Route::view('/', 'main');
Route::get('/docs/{id}/pdf', 'DocumentController@getSinglePdfFile');
Route::get('/docs/{id}/native', 'DocumentController@getSingleNativeFile');

Route::get('/transmittals/{id}', 'TransmittalController@showTransmittalFolder');
Route::get('/transmittals/{trans_id}/files/{file_id}', 'TransmittalController@getFileFromFolder');

//Route::view('/service', 'service');
//Route::get('/service', 'ServiceController@index')->name('home');

Route::get('/service/max_rev', 'ServiceController@maxRevUpdate');
Route::get('/service/import_json', 'ServiceController@importAllJson');


//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
