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
Route::get('/', 'HomeController@index');
Route::resource('/telescope', 'TelescopeController');
Route::get('/profile', 'ProfileController@showForm');
Route::post('/profile', 'ProfileController@submit');
Route::resource('/eyepiece', 'EyepieceController');
Route::resource('/manufacturer', 'ManufacturerController');
Route::resource('/product-line', 'ProductLineController');
Route::get('/admin', 'AdminController@home');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/api/region', 'API\RegionAPIController@index');
Route::get('/api/region/{id}', 'API\RegionAPIController@details');
Route::post('/api/telescope', 'API\TelescopeAPIController@add')->middleware('auth');
Route::delete('/api/telescope/{id}', 'API\TelescopeAPIController@remove')->middleware('auth');
Route::put('/api/telescope/{id}', 'API\TelescopeAPIController@update')->middleware('auth');
