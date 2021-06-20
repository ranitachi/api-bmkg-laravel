<?php

use Illuminate\Support\Facades\Route;

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

Route::get('perkiraan-cuaca/{daerah?}','ApiController@perkiraan_cuaca');

Route::get('gempa/{jenis?}','ApiController@gempa');

Route::get('getGempaTerkiniGeoJson','ApiController@getGempaTerkiniGeoJson');
Route::get('getGempaM5GeoJson','ApiController@getGempaM5GeoJson');
Route::get('getGempaDirasakanGeoJson','ApiController@getGempaDirasakanGeoJson');