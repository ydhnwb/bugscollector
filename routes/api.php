<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::apiResource('bugs','Bug\BugController');

Route::post('ydh','Bug\BugController@store');
Route::get('ydh','Bug\BugController@index');
Route::post('ydh/{id}','Bug\BugController@update');
Route::get('ydh/{id}','Bug\BugController@show');
Route::delete('ydh/{id}', 'Bug\BugController@destroy');
Route::post('ydh/search/result', 'Bug\BugController@search');


Route::get('/news','NewsController@index');
Route::post('/news','NewsController@store');
Route::get('news/{id}','NewsController@show');
Route::post('news/search/result', 'NewsController@search');
Route::delete('news/{id}', 'NewsController@destroy');
