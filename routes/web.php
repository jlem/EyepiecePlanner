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

Route::resource('/telescope', 'TelescopeController');
Route::resource('/eyepiece', 'EyepieceController');
Route::resource('/manufacturer', 'ManufacturerController');
Route::resource('/product-line', 'ProductLineController');

Auth::routes();

Route::get('/home', 'HomeController@index');
