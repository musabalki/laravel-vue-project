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

Route::put('app/edit_tag','AdminController@editTag')->middleware('cors');
Route::get('app/get_tag','AdminController@getTag')->middleware('cors');
Route::post('app/create_tag','AdminController@addTag')->middleware('cors');
Route::post('app/delete_tag','AdminController@deleteTag')->middleware('cors');
Route::post('app/delete_image','AdminController@deleteImage');
Route::get('/new','TestController@controllerMethod');
Route::post('app/upload','AdminController@upload')->middleware('cors');
Route::any('/{slug}',function(){
    return view('welcome');
});