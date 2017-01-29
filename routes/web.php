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

Route::get('/test', function () {
    $eyepieces = EPP\Eyepiece::with(['productLine', 'manufacturer'])
        ->join('product_lines', 'product_lines.id', '=', 'eyepieces.product_line_id')
        ->join('manufacturers', 'manufacturers.id', '=', 'eyepieces.manufacturer_id')
        ->select([
            'eyepieces.id',
            'eyepieces.apparent_field',
            'eyepieces.focal_length',
            'eyepieces.eye_relief',
            'eyepieces.field_stop',
            'eyepieces.barrel_size',
            'manufacturers.name as manufacturer_name',
            'product_lines.name as product_name'
        ])
        ->orderBy('manufacturers.name', 'ASC')
        ->orderBy('product_lines.name', 'ASC')
        ->orderBy('eyepieces.focal_length', 'ASC')
        ->get()
        ->toJson();

    $eyepieces = str_replace('")', '&quot;)', $eyepieces);
    return view('test', compact('eyepieces'));
});
Route::get('/', 'ComparisonController@compare');
Route::resource('/telescope', 'TelescopeController');
Route::resource('/eyepiece', 'EyepieceController');
Route::resource('/manufacturer', 'ManufacturerController');
Route::resource('/product-line', 'ProductLineController');

Auth::routes();

Route::get('/home', 'HomeController@index');
